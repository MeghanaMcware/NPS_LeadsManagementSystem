<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\SpreadsheetParserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadImportController extends Controller
{
    public function __construct(
        protected SpreadsheetParserService $parser
    ) {}

    /**
     * Display Add / Import interface.
     */
    public function index(): View
    {
        return view('admin.leadsimport.index');
    }

    /**
     * Download sample CSV file matching school spreadsheet format.
     */
    public function downloadSample(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="leads_import_sample.csv"',
        ];

        return response()->stream(function (): void {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($handle, [
                'Name',
                'Phone Number',
                'Admission for which grade?',
                'City',
                'Preferred time to call',
                'Remarks',
            ]);

            fputcsv($handle, [
                'Anand Kumar',
                '9513477488',
                'Grade 1',
                'Anchepalya',
                'Morning 10 AM - 12 PM',
                'Looking for Grade 1 admission',
            ]);

            fputcsv($handle, [
                'Nabila Ruhi',
                '9986176580',
                'Grade 2',
                'Bengaluru',
                'Afternoon 2 PM',
                'Enquired regarding school curriculum',
            ]);

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Preview uploaded spreadsheet, detect columns, and check for duplicates.
     */
    public function preview(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:5120'], // Max 5MB
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if (! in_array(strtolower($extension), ['csv', 'xlsx', 'txt'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Please upload a valid .xlsx or .csv spreadsheet file.',
            ], 422);
        }

        $storedPath = $file->store('temp_imports');
        $fullPath = Storage::path($storedPath);

        $parsed = $this->parser->parse($fullPath, $extension);
        $headers = $parsed['headers'];
        $rows = $parsed['rows'];

        if (empty($headers) || empty($rows)) {
            Storage::delete($storedPath);

            return response()->json([
                'success' => false,
                'message' => 'The uploaded file contains no data or could not be parsed.',
            ], 422);
        }

        // Suggest mapping for each header
        $suggestedMapping = [];
        $phoneColIndex = null;

        foreach ($headers as $index => $header) {
            $target = $this->parser->guessTarget($header);
            $suggestedMapping[$index] = $target;

            if ($target === 'phone' && $phoneColIndex === null) {
                $phoneColIndex = $index;
            }
        }

        // Duplicate check against existing phone numbers
        $duplicateCount = 0;
        if ($phoneColIndex !== null) {
            $extractedPhones = [];
            foreach ($rows as $row) {
                $rawPhone = $row[$phoneColIndex] ?? null;
                $phone = $this->parser->normalizePhone($rawPhone);
                if ($phone) {
                    $extractedPhones[] = $phone;
                }
            }

            if (! empty($extractedPhones)) {
                $uniquePhones = array_unique($extractedPhones);
                $duplicateCount = Lead::query()->whereIn('phone', $uniquePhones)->count();
            }
        }

        return response()->json([
            'success' => true,
            'file_token' => $storedPath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'headers' => $headers,
            'total_rows' => count($rows),
            'duplicate_count' => $duplicateCount,
            'suggested_mapping' => $suggestedMapping,
        ]);
    }

    /**
     * Process and import the validated spreadsheet rows into database.
     */
    public function process(Request $request): JsonResponse
    {
        $request->validate([
            'file_token' => ['required', 'string'],
            'mapping' => ['required', 'array'],
            'dup_mode' => ['required', 'in:skip,update'],
            'default_source' => ['nullable', 'string'],
        ]);

        $fileToken = $request->input('file_token');
        if (! Storage::exists($fileToken)) {
            return response()->json([
                'success' => false,
                'message' => 'Uploaded file session has expired. Please upload the file again.',
            ], 422);
        }

        $fullPath = Storage::path($fileToken);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        $parsed = $this->parser->parse($fullPath, $extension);
        $rows = $parsed['rows'];

        $mapping = $request->input('mapping'); // index => field_name ('name', 'phone', 'city', etc.)
        $dupMode = $request->input('dup_mode');
        $defaultSource = $request->input('default_source') ?: 'Google Form';

        $imported = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($rows as $row) {
            $data = [
                'name' => null,
                'phone' => null,
                'city' => null,
                'email' => null,
                'preferred_time_to_call' => null,
                'interested_in' => null,
                'remarks' => null,
                'source' => $defaultSource,
            ];

            foreach ($mapping as $colIndex => $field) {
                if ($field === 'skip' || ! isset($row[$colIndex])) {
                    continue;
                }

                $val = trim((string) $row[$colIndex]);

                if ($field === 'phone') {
                    $data['phone'] = $this->parser->normalizePhone($val);
                } elseif ($field === 'remarks') {
                    if ($val !== '') {
                        $data['remarks'] = $data['remarks'] !== null ? $data['remarks'].' | '.$val : $val;
                    }
                } elseif (array_key_exists($field, $data)) {
                    $data[$field] = $val !== '' ? $val : null;
                }
            }

            // A valid name and phone are required
            if (empty($data['name']) || empty($data['phone'])) {
                $skipped++;

                continue;
            }

            $existingLead = Lead::query()->where('phone', $data['phone'])->first();

            if ($existingLead) {
                if ($dupMode === 'update') {
                    $updatePayload = array_filter([
                        'name' => $data['name'],
                        'city' => $data['city'] ?? $existingLead->city,
                        'email' => $data['email'] ?? $existingLead->email,
                        'preferred_time_to_call' => $data['preferred_time_to_call'] ?? $existingLead->preferred_time_to_call,
                        'interested_in' => $data['interested_in'] ?? $existingLead->interested_in,
                        'remarks' => $data['remarks'] ?? $existingLead->remarks,
                    ], fn ($v) => $v !== null);

                    $existingLead->update($updatePayload);
                    $updated++;
                } else {
                    $skipped++;
                }
            } else {
                $data['status'] = 'new';
                Lead::create($data);
                $imported++;
            }
        }

        // Clean up temporary file
        Storage::delete($fileToken);

        $parts = [];
        if ($imported > 0) {
            $parts[] = "{$imported} leads imported";
        }
        if ($updated > 0) {
            $parts[] = "{$updated} existing leads updated";
        }
        if ($skipped > 0) {
            $parts[] = "{$skipped} skipped";
        }

        $message = ! empty($parts) ? implode(', ', $parts).'.' : 'Import completed.';

        return response()->json([
            'success' => true,
            'imported' => $imported,
            'updated' => $updated,
            'skipped' => $skipped,
            'message' => $message,
        ]);
    }

    /**
     * Store a single lead submitted from the manual Add Lead tab.
     */
    public function storeSingle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2'],
            'phone' => ['required', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email'],
            'preferred_time_to_call' => ['nullable', 'string', 'max:100'],
            'interested_in' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'max:50'],
            'remarks' => ['nullable', 'string'],
        ]);

        $phone = $this->parser->normalizePhone($validated['phone']);
        if (! $phone) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid 10-digit mobile number.',
            ], 422);
        }

        $validated['phone'] = $phone;
        $validated['source'] = $validated['source'] ?: 'Google Form';
        $validated['status'] = strtolower($validated['status'] ?: 'new');

        $lead = Lead::query()->updateOrCreate(
            ['phone' => $phone],
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => "Lead {$lead->name} saved successfully.",
            'lead' => $lead,
        ]);
    }
}
