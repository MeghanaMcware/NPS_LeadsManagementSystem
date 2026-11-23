<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WhatsAppLeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // 1. Resolve phone (accepts phone, mobile, mobile_number, wa_number, destination)
        $rawPhone = $request->input('phone')
            ?? $request->input('mobile_number')
            ?? $request->input('mobile')
            ?? $request->input('wa_number')
            ?? $request->input('destination');

        if (! $rawPhone) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number is required.',
                'errors' => [
                    'phone' => ['Please provide a valid mobile number.'],
                ],
            ], 422);
        }

        // Clean phone (handles 'p:+919164432664', '+91 9164432664', '919164432664', etc.)
        $digits = preg_replace('/\D/', '', (string) $rawPhone);
        if (strlen($digits) > 10 && str_starts_with($digits, '91')) {
            $digits = substr($digits, 2);
        } elseif (strlen($digits) >= 10) {
            $digits = substr($digits, -10);
        }

        if (strlen($digits) !== 10) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid 10-digit mobile number.',
                'errors' => [
                    'phone' => ['Mobile number must be a valid 10-digit number.'],
                ],
            ], 422);
        }

        // 2. Resolve Parent's Name (nullable, defaults to 'WhatsApp Lead')
        $rawName = $request->input('parent_name') ?? $request->input('name');
        $name = $rawName ? trim((string) $rawName) : null;

        // 3. Resolve Grade Applying For (nullable)
        $rawGrade = $request->input('grade')
            ?? $request->input('interested_in')
            ?? $request->input('class')
            ?? $request->input('class_applying');
        $grade = $rawGrade ? trim((string) $rawGrade) : null;

        // 4. Resolve Email (optional / nullable)
        $rawEmail = $request->input('email');
        $email = null;
        if ($rawEmail && filter_var(trim((string) $rawEmail), FILTER_VALIDATE_EMAIL)) {
            $email = strtolower(trim((string) $rawEmail));
        }

        // 5. Resolve Source / Type (defaults to 'WhatsApp Chatbot')
        $rawSource = $request->input('source') ?? $request->input('type');
        $source = $rawSource ? trim((string) $rawSource) : 'WhatsApp Chatbot';

        // Store or update in the existing leads table
        $existingLead = Lead::query()->where('phone', $digits)->first();

        if ($existingLead) {
            $updatePayload = [];

            if (! empty($name)) {
                $updatePayload['name'] = $name;
            }
            if (! empty($grade)) {
                $updatePayload['interested_in'] = $grade;
            }
            if (! empty($email)) {
                $updatePayload['email'] = $email;
            }
            if (! empty($source) && empty($existingLead->source)) {
                $updatePayload['source'] = $source;
            }

            if (! empty($updatePayload)) {
                $existingLead->update($updatePayload);
            }

            $lead = $existingLead;
            $isNew = false;
        } else {
            $lead = Lead::create([
                'name' => $name ?: 'WhatsApp Lead',
                'phone' => $digits,
                'email' => $email,
                'interested_in' => $grade,
                'source' => $source,
                'status' => 'new',
            ]);
            $isNew = true;
        }

        return response()->json([
            'success' => true,
            'message' => $isNew ? 'WhatsApp lead created successfully.' : 'WhatsApp lead updated successfully.',
            'lead' => [
                'id' => $lead->id,
                'name' => $lead->name,
                'phone' => $lead->phone,
                'email' => $lead->email,
                'interested_in' => $lead->interested_in,
                'source' => $lead->source,
                'status' => $lead->status,
            ],
        ], $isNew ? 201 : 200);
    }
}
