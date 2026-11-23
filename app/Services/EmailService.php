<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\LeadMessage;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class EmailService
{
    /**
     * All 5 pre-approved NPS KGL email templates mapped to Blade views and subjects.
     *
     * @var array<string, array{view: string, subject: string, campaign: string}>
     */
    public const TEMPLATES = [
        'greeting' => [
            'view' => 'emails.welcome_greeting',
            'subject' => 'Admission Enquiry Received – NPS KGL',
            'campaign' => 'npskgl_welcome_email',
        ],
        'followup' => [
            'view' => 'emails.followup',
            'subject' => 'Follow-up on Your Admission Enquiry – NPS KGL',
            'campaign' => 'npskgl_followup_email',
        ],
        'appointment' => [
            'view' => 'emails.appointment_confirmation',
            'subject' => 'Campus Visit Appointment Confirmed – NPS KGL',
            'campaign' => 'npskgl_appointment_email',
        ],
        'thankyou' => [
            'view' => 'emails.thank_you',
            'subject' => 'Thank You for Visiting NPS KGL',
            'campaign' => 'npskgl_thankyou_email',
        ],
        'promotion' => [
            'view' => 'emails.admission_promotion',
            'subject' => 'Admissions Open – National Public School KGL',
            'campaign' => 'npskgl_admission_promotion_email',
        ],
    ];

    protected ?string $apiKey;

    protected ?string $apiUrl;

    protected ?string $senderName;

    protected ?string $senderEmail;

    public function __construct(
        ?string $apiKey = null,
        ?string $apiUrl = null,
        ?string $senderName = null,
        ?string $senderEmail = null
    ) {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
    }

    public function getApiKey(): string
    {
        return $this->apiKey ?? (string) config('services.brevo.api_key', '');
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl ?? (string) config('services.brevo.url', 'https://api.brevo.com/v3/smtp/email');
    }

    public function getSenderName(): string
    {
        return $this->senderName ?? (string) config('services.brevo.sender_name', 'National Public School - KGL');
    }

    public function getSenderEmail(): string
    {
        return $this->senderEmail ?? (string) config('services.brevo.sender_email', 'admissions@npskgl.com');
    }

    /**
     * Dispatch email to a lead using the Brevo transactional email API.
     *
     * @param  array<string, mixed>  $data
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function send(Lead $lead, string $templateKey, array $data = []): array
    {
        if (empty($lead->email) || ! filter_var($lead->email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => "Lead has no valid email address ({$lead->email}).",
            ];
        }

        $template = self::TEMPLATES[$templateKey] ?? null;
        if (! $template) {
            return [
                'success' => false,
                'message' => "Unknown email template '{$templateKey}'.",
            ];
        }

        $mailData = array_merge([
            'parentName' => $lead->name,
            'studentName' => $lead->name,
            'grade' => $lead->interested_in,
            'academicYear' => '2027-28',
        ], $data);

        $htmlContent = view($template['view'], $mailData)->render();
        $subject = $template['subject'];

        $apiKey = $this->getApiKey();
        $apiUrl = $this->getApiUrl();
        $senderName = $this->getSenderName();
        $senderEmail = $this->getSenderEmail();

        $payload = [
            'sender' => [
                'name' => $senderName,
                'email' => $senderEmail,
            ],
            'to' => [
                [
                    'email' => $lead->email,
                    'name' => $lead->name ?: 'Parent',
                ],
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ];

        // Simulation / Sandbox mode if dummy credentials or blank
        $isDummyKey = empty($apiKey)
            || str_starts_with($apiKey, 'xkeysib-dummy-')
            || $apiKey === '<YOUR_BREVO_API_KEY>';

        if ($isDummyKey) {
            $leadMessage = LeadMessage::create([
                'lead_id' => $lead->id,
                'channel' => 'email',
                'template_type' => $templateKey,
                'note' => "{$subject} - Sent to {$lead->email} (Brevo Simulation Mode)",
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            $lead->update([
                'email_sent_at' => now(),
                'last_contact_at' => now(),
                'status' => $lead->status === 'new' ? 'contacted' : $lead->status,
            ]);

            return [
                'success' => true,
                'message' => "Email '{$subject}' logged successfully (Brevo Simulation Mode).",
                'lead_message' => $leadMessage,
            ];
        }

        try {
            /** @var Response $response */
            $response = Http::timeout(15)
                ->withHeaders([
                    'api-key' => $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($apiUrl, $payload);

            $isSuccess = $response->successful();
            $responseData = $response->json();

            $status = $isSuccess ? 'sent' : 'failed';
            $errorMessage = $isSuccess ? null : ($responseData['message'] ?? $response->body());

            $leadMessage = LeadMessage::create([
                'lead_id' => $lead->id,
                'channel' => 'email',
                'template_type' => $templateKey,
                'note' => $isSuccess
                    ? "{$subject} - Sent via Brevo (MessageId: ".($responseData['messageId'] ?? 'N/A').')'
                    : "Brevo Error: {$errorMessage} | {$subject}",
                'status' => $status,
                'sent_at' => now(),
            ]);

            if ($isSuccess) {
                $lead->update([
                    'email_sent_at' => now(),
                    'last_contact_at' => now(),
                    'status' => $lead->status === 'new' ? 'contacted' : $lead->status,
                ]);

                return [
                    'success' => true,
                    'message' => "Email '{$subject}' delivered successfully via Brevo API.",
                    'lead_message' => $leadMessage,
                ];
            }

            Log::error('Brevo API delivery error', [
                'lead_id' => $lead->id,
                'email' => $lead->email,
                'response' => $responseData,
            ]);

            return [
                'success' => false,
                'message' => 'Brevo API rejected the request: '.($errorMessage ?: 'Unknown error'),
                'lead_message' => $leadMessage,
                'error' => $errorMessage,
            ];
        } catch (Throwable $e) {
            Log::error('Brevo API connection error', [
                'lead_id' => $lead->id,
                'email' => $lead->email,
                'error' => $e->getMessage(),
            ]);

            $leadMessage = LeadMessage::create([
                'lead_id' => $lead->id,
                'channel' => 'email',
                'template_type' => $templateKey,
                'note' => "Brevo Connection Exception: {$e->getMessage()} | {$subject}",
                'status' => 'failed',
                'sent_at' => now(),
            ]);

            return [
                'success' => false,
                'message' => 'Could not connect to Brevo API: '.$e->getMessage(),
                'lead_message' => $leadMessage,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send Welcome Greeting Email (npskgl_welcome_email).
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendGreeting(Lead $lead, ?string $studentName = null, ?string $academicYear = '2027-28'): array
    {
        return $this->send($lead, 'greeting', [
            'parentName' => $lead->name,
            'studentName' => $studentName ?: $lead->name,
            'grade' => $lead->interested_in,
            'academicYear' => $academicYear ?: '2027-28',
        ]);
    }

    /**
     * Send Follow-up Email (npskgl_followup_email).
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendFollowup(Lead $lead, ?string $studentName = null): array
    {
        return $this->send($lead, 'followup', [
            'parentName' => $lead->name,
            'studentName' => $studentName ?: ($lead->interested_in ? 'Admission in '.$lead->interested_in : 'your child'),
        ]);
    }

    /**
     * Send Appointment Confirmation Email (npskgl_appointment_email).
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendAppointment(
        Lead $lead,
        ?string $studentName,
        ?string $grade,
        string $date,
        string $time
    ): array {
        return $this->send($lead, 'appointment', [
            'parentName' => $lead->name,
            'studentName' => $studentName ?: $lead->name,
            'grade' => $grade ?: $lead->interested_in,
            'appointmentDate' => $date,
            'appointmentTime' => $time,
        ]);
    }

    /**
     * Send Thank You Email (npskgl_thankyou_email).
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendThankYou(Lead $lead): array
    {
        return $this->send($lead, 'thankyou', [
            'parentName' => $lead->name,
        ]);
    }

    /**
     * Send Admission Promotion Announcement Email (npskgl_admission_promotion_email).
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendPromotion(Lead $lead, ?string $academicYear = '2027-28'): array
    {
        return $this->send($lead, 'promotion', [
            'parentName' => $lead->name,
            'academicYear' => $academicYear ?: '2027-28',
        ]);
    }
}
