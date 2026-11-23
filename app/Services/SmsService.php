<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\LeadMessage;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class SmsService
{
    /**
     * All 5 pre-approved NPS KGL SMS templates.
     *
     * @var array<string, array{
     *     template_name: string,
     *     variables: array<int, string>,
     *     body: string
     * }>
     */
    public const TEMPLATES = [
        'greeting' => [
            'template_name' => 'npskgl_welcome_sms',
            'variables' => ['Parent Name', 'Grade'],
            'body' => 'Dear {{1}}, thank you for your admission enquiry at National Public School – Kempegowda Layout (NPS KGL) for {{2}}. Your enquiry has been received successfully. Our admission team will contact you shortly. Thank you!',
        ],
        'followup' => [
            'template_name' => 'npskgl_followup_sms',
            'variables' => ['Parent Name'],
            'body' => 'Dear {{1}}, this is a gentle reminder regarding your admission enquiry at National Public School – Kempegowda Layout (NPS KGL). Our Admissions Team would be pleased to assist you with the admission process. Please feel free to contact us for further information.',
        ],
        'appointment' => [
            'template_name' => 'npskgl_appointment_sms',
            'variables' => ['Parent Name', 'Visit Date', 'Visit Time'],
            'body' => "Dear {{1}}, your appointment regarding the admission enquiry at National Public School – Kempegowda Layout (NPS KGL) has been confirmed on {{2}} at {{3}}. We look forward to meeting you.\n– Admissions Team, NPS KGL",
        ],
        'thankyou' => [
            'template_name' => 'npskgl_thankyou_sms',
            'variables' => ['Parent Name'],
            'body' => "Dear {{1}}, thank you for visiting NPS KGL. We appreciate your interest in our school and hope you had a wonderful experience. We look forward to welcoming your child to NPS KGL\n.For any admission-related assistance, please contact our team. – Admissions Team, NPS KGL",
        ],
        'promotion' => [
            'template_name' => 'npskgl_admission_promotion_sms',
            'variables' => [],
            'body' => 'Admissions Open at National Public School – Kempegowda Layout (NPS KGL).Explore admission opportunities for the upcoming academic year. Contact our admission team for details and campus visit information. – NPS KGL',
        ],
    ];

    protected ?string $apiKey;

    protected ?string $apiUrl;

    protected ?string $sender;

    public function __construct(
        ?string $apiKey = null,
        ?string $apiUrl = null,
        ?string $sender = null
    ) {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
        $this->sender = $sender;
    }

    public function getApiKey(): string
    {
        return $this->apiKey ?? (string) config('services.brevo.api_key', '');
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl ?? (string) config('services.brevo.sms_url', 'https://api.brevo.com/v3/transactionalSMS/sms');
    }

    public function getSender(): string
    {
        return $this->sender ?? (string) config('services.brevo.sms_sender', 'NPSKGL');
    }

    /**
     * Get all SMS templates metadata.
     *
     * @return array<string, array{template_name: string, variables: array<int, string>, body: string}>
     */
    public function getTemplates(): array
    {
        return self::TEMPLATES;
    }

    /**
     * Render template body replacing dynamic {{1}}, {{2}} with supplied values.
     *
     * @param  array<int, string>  $params
     */
    public function renderText(string $templateKey, array $params = []): string
    {
        $template = self::TEMPLATES[$templateKey] ?? null;
        if (! $template) {
            return '';
        }

        $text = $template['body'];
        foreach (array_values($params) as $idx => $val) {
            $num = $idx + 1;
            $text = str_replace('{{'.$num.'}}', (string) $val, $text);
        }

        return $text;
    }

    /**
     * Send SMS to a lead using Brevo's Transactional SMS API.
     *
     * @param  array<int, string>  $params
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function send(Lead $lead, string $templateKey, array $params = []): array
    {
        $template = self::TEMPLATES[$templateKey] ?? null;
        if (! $template) {
            return [
                'success' => false,
                'message' => "Unknown SMS template '{$templateKey}'.",
            ];
        }

        // Clean recipient phone (international format e.g. 919845012345)
        $digits = preg_replace('/\D/', '', (string) $lead->phone);
        if (strlen($digits) === 10) {
            $recipient = '91'.$digits;
        } elseif (strlen($digits) > 10 && str_starts_with($digits, '91')) {
            $recipient = $digits;
        } else {
            return [
                'success' => false,
                'message' => "Lead phone '{$lead->phone}' is not a valid mobile number.",
            ];
        }

        $renderedText = $this->renderText($templateKey, $params);

        $apiKey = $this->getApiKey();
        $apiUrl = $this->getApiUrl();
        $sender = $this->getSender();

        // Brevo Transactional SMS Payload
        $payload = [
            'sender' => $sender,
            'recipient' => $recipient,
            'content' => $renderedText,
            'type' => 'transactional',
        ];

        // Simulation / Sandbox mode if dummy key
        $isDummyKey = empty($apiKey)
            || str_starts_with($apiKey, 'xkeysib-dummy-')
            || $apiKey === '<YOUR_BREVO_API_KEY>';

        if ($isDummyKey) {
            $leadMessage = LeadMessage::create([
                'lead_id' => $lead->id,
                'channel' => 'sms',
                'template_type' => $templateKey,
                'note' => "{$template['template_name']}: {$renderedText} (Brevo SMS Simulation Mode)",
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            $lead->update([
                'sms_sent_at' => now(),
                'last_contact_at' => now(),
                'status' => $lead->status === 'new' ? 'contacted' : $lead->status,
            ]);

            return [
                'success' => true,
                'message' => "SMS '{$template['template_name']}' logged successfully (Brevo SMS Simulation Mode).",
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
                'channel' => 'sms',
                'template_type' => $templateKey,
                'note' => $isSuccess
                    ? "{$template['template_name']}: {$renderedText} (Brevo SMS Reference: ".($responseData['reference'] ?? 'N/A').')'
                    : "Brevo SMS Error: {$errorMessage} | {$renderedText}",
                'status' => $status,
                'sent_at' => now(),
            ]);

            if ($isSuccess) {
                $lead->update([
                    'sms_sent_at' => now(),
                    'last_contact_at' => now(),
                    'status' => $lead->status === 'new' ? 'contacted' : $lead->status,
                ]);

                return [
                    'success' => true,
                    'message' => 'SMS delivered successfully via Brevo.',
                    'lead_message' => $leadMessage,
                ];
            }

            Log::error('Brevo SMS API delivery error', [
                'lead_id' => $lead->id,
                'phone' => $recipient,
                'response' => $responseData,
            ]);

            return [
                'success' => false,
                'message' => 'Brevo SMS API rejected the request: '.($errorMessage ?: 'Unknown error'),
                'lead_message' => $leadMessage,
                'error' => $errorMessage,
            ];
        } catch (Throwable $e) {
            Log::error('Brevo SMS connection error', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage(),
            ]);

            $leadMessage = LeadMessage::create([
                'lead_id' => $lead->id,
                'channel' => 'sms',
                'template_type' => $templateKey,
                'note' => "Brevo SMS Connection Exception: {$e->getMessage()} | {$renderedText}",
                'status' => 'failed',
                'sent_at' => now(),
            ]);

            return [
                'success' => false,
                'message' => 'Could not connect to Brevo SMS API: '.$e->getMessage(),
                'lead_message' => $leadMessage,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send Welcome Greeting SMS (npskgl_welcome_sms).
     *
     * Dynamic variables: {{1}} Parent Name, {{2}} Grade
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendGreeting(Lead $lead, ?string $grade = null): array
    {
        $parentName = $lead->name ?: 'Parent';
        $admissionGrade = $grade ?: ($lead->interested_in ?: 'your chosen grade');

        return $this->send($lead, 'greeting', [$parentName, $admissionGrade]);
    }

    /**
     * Send Follow-up Reminder SMS (npskgl_followup_sms).
     *
     * Dynamic variables: {{1}} Parent Name
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendFollowup(Lead $lead): array
    {
        $parentName = $lead->name ?: 'Parent';

        return $this->send($lead, 'followup', [$parentName]);
    }

    /**
     * Send Appointment Confirmation SMS (npskgl_appointment_sms).
     *
     * Dynamic variables: {{1}} Parent Name, {{2}} Visit Date, {{3}} Visit Time
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendAppointment(Lead $lead, string $date, string $time): array
    {
        $parentName = $lead->name ?: 'Parent';

        return $this->send($lead, 'appointment', [$parentName, $date, $time]);
    }

    /**
     * Send Thank You SMS (npskgl_thankyou_sms).
     *
     * Dynamic variables: {{1}} Parent Name
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendThankYou(Lead $lead): array
    {
        $parentName = $lead->name ?: 'Parent';

        return $this->send($lead, 'thankyou', [$parentName]);
    }

    /**
     * Send Admission Promotion Announcement SMS (npskgl_admission_promotion_sms).
     *
     * No dynamic variables required.
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendPromotion(Lead $lead): array
    {
        return $this->send($lead, 'promotion');
    }
}
