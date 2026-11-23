<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\EmailService;
use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class FrontendEnquiryController extends Controller
{
    /**
     * Handle admission enquiry submission from the frontend form.
     */
    public function submit(
        Request $request,
        WhatsAppService $whatsAppService,
        EmailService $emailService
    ): JsonResponse {
        $validated = $request->validate([
            'parent_name' => ['required', 'string', 'min:2', 'max:60'],
            'mobile_number' => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'email' => ['nullable', 'email', 'max:100'],
            'grade' => ['required', 'string', 'max:50'],
        ]);

        $phone = preg_replace('/\D/', '', $validated['mobile_number']);
        if (strlen($phone) > 10 && str_starts_with($phone, '91')) {
            $phone = substr($phone, 2);
        }

        $existingLead = Lead::query()->where('phone', $phone)->first();

        if ($existingLead) {
            $existingLead->update([
                'name' => trim($validated['parent_name']),
                'email' => $validated['email'] ?? $existingLead->email,
                'interested_in' => $validated['grade'],
            ]);
            $lead = $existingLead;
        } else {
            $lead = Lead::create([
                'name' => trim($validated['parent_name']),
                'phone' => $phone,
                'email' => $validated['email'] ?? null,
                'interested_in' => $validated['grade'],
                'source' => 'Website',
                'status' => 'new',
            ]);
        }

        // Send WhatsApp Welcome Greeting (npskgl_welcome_greeting)
        try {
            $childInfo = $lead->interested_in ? $lead->interested_in : 'your child';
            $whatsAppService->sendGreeting($lead, $childInfo);
        } catch (Throwable) {
            // Silently continue if WhatsApp service fails so parent submission succeeds
        }

        // Send Welcome Greeting Email (npskgl_welcome_email) via EmailService if email provided
        if (! empty($lead->email)) {
            try {
                $emailService->sendGreeting($lead);
            } catch (Throwable) {
                // Silently continue if Email service fails so parent submission succeeds
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you. Our admissions team will get in touch with you shortly.',
            'lead_id' => $lead->id,
        ]);
    }
}
