<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Services\SpreadsheetParserService;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportPublicExcelsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:import-excels {--file= : Path to specific Excel file} {--fresh : Delete existing leads before importing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import leads from the Excel files stored in the public folder (Meta Leads, WhatsApp, Call Leads)';

    public function handle(SpreadsheetParserService $parser): int
    {
        if ($this->option('fresh')) {
            $deleted = Lead::query()->delete();
            $this->warn("Deleted {$deleted} existing lead(s) for fresh import.");
        }

        $filePath = $this->option('file') ?: public_path('NPS -meta-Leads (3).xlsx');

        if (! file_exists($filePath)) {
            $this->error("File not found at: {$filePath}");

            return self::FAILURE;
        }

        $this->info("Loading Excel workbook from: {$filePath}");

        $spreadsheet = IOFactory::load($filePath);

        $sheetsConfig = [
            'Meta Leads' => [
                'source' => 'Meta Leads',
                'nameCol' => 2,
                'phoneCol' => 3,
                'cityCol' => 4,
                'emailCol' => 5,
                'prefTimeCol' => 6,
                'gradeCol' => 7,
                'remarksCol' => 8,
                'statusCol' => 9,
                'extraRemarksCol' => 10,
            ],
            'Whatsapp' => [
                'source' => 'WhatsApp',
                'nameCol' => 2,
                'phoneCol' => 3,
                'cityCol' => 4,
                'emailCol' => 5,
                'prefTimeCol' => 6,
                'gradeCol' => 7,
                'remarksCol' => 8,
                'statusCol' => null,
                'extraRemarksCol' => null,
            ],
            'Call Leads ' => [
                'source' => 'Call Leads',
                'nameCol' => 1,
                'phoneCol' => 2,
                'cityCol' => 3,
                'emailCol' => 4,
                'prefTimeCol' => 5,
                'gradeCol' => 6,
                'remarksCol' => 7,
                'statusCol' => null,
                'extraRemarksCol' => 8,
            ],
        ];

        $summary = [];
        $totalImported = 0;
        $totalUpdated = 0;
        $totalSkipped = 0;

        foreach ($sheetsConfig as $sheetName => $cfg) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            if (! $sheet) {
                $this->warn("Sheet '{$sheetName}' not found in workbook.");

                continue;
            }

            $rows = $sheet->toArray(null, true, true, false);
            $sheetImported = 0;
            $sheetUpdated = 0;
            $sheetSkipped = 0;

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $rawPhone = $row[$cfg['phoneCol']] ?? null;
                $phone = $parser->normalizePhone($rawPhone);
                $name = $this->cleanString($row[$cfg['nameCol']] ?? null);

                // Skip if neither valid phone nor name
                if (! $phone && ! $name) {
                    $sheetSkipped++;

                    continue;
                }

                $city = $this->cleanString($row[$cfg['cityCol']] ?? null);
                $email = $this->cleanString($row[$cfg['emailCol']] ?? null);
                $prefTime = $this->cleanString($row[$cfg['prefTimeCol']] ?? null);
                $grade = $this->cleanString($row[$cfg['gradeCol']] ?? null);

                $notes = [];
                $r1 = $this->cleanString($row[$cfg['remarksCol']] ?? null);
                if ($r1) {
                    $notes[] = [
                        'text' => $r1,
                        'date' => '21 Nov 2026',
                        'author' => 'Admissions Team',
                        'type' => $cfg['source'] === 'Call Leads' ? 'call' : ($cfg['source'] === 'WhatsApp' ? 'whatsapp' : 'note'),
                    ];
                }

                if ($cfg['extraRemarksCol'] !== null) {
                    $r2 = $this->cleanString($row[$cfg['extraRemarksCol']] ?? null);
                    if ($r2 && $r2 !== $r1) {
                        $notes[] = [
                            'text' => $r2,
                            'date' => '21 Nov 2026',
                            'author' => 'Counsellor',
                            'type' => 'followup',
                        ];
                    }
                }

                $statusRaw = $cfg['statusCol'] !== null ? $this->cleanString($row[$cfg['statusCol']] ?? null) : null;
                $status = $this->resolveStatus($statusRaw, $r1);

                $phoneKey = $phone ?: ('N/A-'.md5(($name ?? '').$i));

                /** @var Lead|null $existing */
                $existing = Lead::where('phone', $phoneKey)->first();

                if ($existing) {
                    $existing->name = $name ?: $existing->name;
                    $existing->city = $city ?: $existing->city;
                    $existing->email = $email ?: $existing->email;
                    $existing->preferred_time_to_call = $prefTime ?: $existing->preferred_time_to_call;
                    $existing->interested_in = $grade ?: $existing->interested_in;

                    $existingNotes = is_array($existing->remarks) ? $existing->remarks : [];
                    foreach ($notes as $newNote) {
                        $alreadyExists = false;
                        foreach ($existingNotes as $en) {
                            if (($en['text'] ?? '') === $newNote['text']) {
                                $alreadyExists = true;
                                break;
                            }
                        }
                        if (! $alreadyExists) {
                            $existingNotes[] = $newNote;
                        }
                    }
                    $existing->remarks = $existingNotes;

                    if ($status !== 'new') {
                        $existing->status = $status;
                    }
                    $existing->save();
                    $sheetUpdated++;
                } else {
                    Lead::create([
                        'name' => $name ?: 'Parent',
                        'phone' => $phoneKey,
                        'city' => $city,
                        'email' => $email,
                        'preferred_time_to_call' => $prefTime,
                        'interested_in' => $grade,
                        'source' => $cfg['source'],
                        'status' => $status,
                        'remarks' => $notes,
                    ]);
                    $sheetImported++;
                }
            }

            $summary[] = [
                'Sheet / Category' => $cfg['source'],
                'New Imported' => $sheetImported,
                'Updated / Merged' => $sheetUpdated,
                'Skipped Rows' => $sheetSkipped,
            ];

            $totalImported += $sheetImported;
            $totalUpdated += $sheetUpdated;
            $totalSkipped += $sheetSkipped;
        }

        $this->table(['Sheet / Category', 'New Imported', 'Updated / Merged', 'Skipped Rows'], $summary);
        $this->info("Import Complete! Total New: {$totalImported}, Total Updated: {$totalUpdated}, Total in DB: ".Lead::count());

        return self::SUCCESS;
    }

    protected function cleanString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $trimmed = trim($value);
        if ($trimmed === '' || $trimmed === '-' || $trimmed === '--' || $trimmed === '---') {
            return null;
        }

        return $trimmed;
    }

    protected function resolveStatus(?string $statusRaw, ?string $remarksRaw): string
    {
        $s = strtolower((string) $statusRaw);
        $r = strtolower((string) $remarksRaw);

        if (str_contains($s, 'payment done') || str_contains($r, 'payment done') || str_contains($s, 'converted')) {
            return 'converted';
        }
        if (str_contains($s, 'callback') || str_contains($s, 'followup') || str_contains($r, 'followup') || str_contains($r, 'callback')) {
            return 'followup';
        }
        if (
            str_contains($s, 'ringing') || str_contains($s, 'busy') || str_contains($s, 'not answering') ||
            str_contains($s, 'disconnected') || str_contains($s, 'contacted') || str_contains($r, 'ringing') ||
            str_contains($r, 'busy') || str_contains($r, 'not answering') || str_contains($r, 'cuts the call') ||
            str_contains($r, 'no response')
        ) {
            return 'contacted';
        }

        return 'new';
    }
}
