<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\LeadMessage;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class WhatsAppService
{
    /**
     * All 5 pre-approved Meta / AiSensy WhatsApp templates for NPS KGL.
     *
     * @var array<string, array{
     *     campaign: string,
     *     name: string,
     *     dynamic_variables: array<int, string>,
     *     body: string
     * }>
     */
    public const TEMPLATES = [
        'greeting' => [
            'campaign' => 'npskgl_welcome_greeting_final',
            'name' => 'Welcome Greeting – New Admission Enquiry',
            'dynamic_variables' => ['Parent Name', 'Grade'],
            'body' => "Hello {{1}}! 👋\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nThank you for your interest in admissions at NPS KGL.\n\nWe have successfully received your admission enquiry for {{2}}.\n\nOur admission team will contact you shortly and guide you through the admission process.\n\nWe look forward to welcoming your child to NPS KGL!\n\nWarm regards,\nAdmissions Team\nNPS KGL",
        ],
        'followup' => [
            'campaign' => 'npskgl_followup_whatsapp_final',
            'name' => 'Follow-up Reminder – Admission Enquiry',
            'dynamic_variables' => ['Parent Name'],
            'body' => "Dear {{1}},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nWe are following up on your admission enquiry.\n\nWe would be happy to assist you with the admission process and address any questions or concerns you may have.\n\nWould you like to connect with our Admissions Counsellor for further guidance?\n\nPlease reply to this message, and our team will be glad to assist you.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout (NPS KGL)",
        ],
        'appointment' => [
            'campaign' => 'npskgl_appointment_whatsapp_final',
            'name' => 'Appointment Confirmation – Campus Visit',
            'dynamic_variables' => ['Parent Name', 'Appointment Date', 'Appointment Time'],
            'body' => "Dear {{1}},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nYour appointment for an admission enquiry has been successfully confirmed.\n\nAppointment Details:\n• Appointment Date: {{2}}\n• Appointment Time: {{3}}\n• Venue: NPS KGL Campus\n\nWe look forward to meeting you and assisting you with the admission process.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout",
        ],
        'thankyou' => [
            'campaign' => 'npskgl_thankyou_whatsapp',
            'name' => 'Thank You – After Campus Visit',
            'dynamic_variables' => ['Parent Name'],
            'body' => "Dear {{1}},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nThank you for visiting our campus and taking the time to explore our facilities and academic environment.\n\nWe hope your visit gave you a better understanding of our school and the learning opportunities we offer.\n\nWe look forward to the opportunity of welcoming your child to NPS KGL.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout",
        ],
        'promotion' => [
            'campaign' => 'npskgl_admission_promotion_whatsapp',
            'name' => 'Offer / Promotion – Admission Announcement',
            'dynamic_variables' => ['Parent Name', 'Academic Year'],
            'body' => "🎓 Admissions Open at NPS KGL!\n\nDear {{1}},\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\nWe are pleased to announce that admissions are now open for the Academic Year {{2}}.\nGive your child the opportunity to learn, grow, and excel in a supportive and enriching educational environment.\nOur Admissions Team is happy to assist you with information about available grades, the admission process, and campus visits.\nFor admission enquiries or further details, please contact our Admissions Team.\nWe look forward to welcoming you NPS KGL!\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout",
        ],
    ];

    protected ?string $apiKey;

    protected ?string $apiUrl;

    protected ?string $userName;

    protected ?string $source;

    public function __construct(
        ?string $apiKey = null,
        ?string $apiUrl = null,
        ?string $userName = null,
        ?string $source = null
    ) {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
        $this->userName = $userName;
        $this->source = $source;
    }

    public function getApiKey(): string
    {
        return $this->apiKey ?? (string) config('services.aisensy.api_key', '');
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl ?? (string) config('services.aisensy.url', 'https://backend.api-wa.co/campaign/mcware/api/v2');
    }

    public function getUserName(): string
    {
        return $this->userName ?? (string) config('services.aisensy.user_name', 'National public school  kempegowda layout');
    }

    public function getSource(): string
    {
        return $this->source ?? (string) config('services.aisensy.source', 'new-landing-page form');
    }

    /**
     * Get all supported WhatsApp templates metadata.
     *
     * @return array<string, array{campaign: string, name: string, dynamic_variables: array<int, string>, body: string}>
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
    public function renderText(string $templateKey, array $params): string
    {
        $template = self::TEMPLATES[$templateKey] ?? null;
        if (! $template) {
            return '';
        }

        $text = $template['body'];
        foreach ($params as $idx => $val) {
            $num = $idx + 1;
            $text = str_replace('{{'.$num.'}}', (string) $val, $text);
        }

        return $text;
    }

    /**
     * Send Welcome Greeting (npskgl_welcome_greeting).
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
     * Send Follow-up Reminder (npskgl_followup_whatsapp).
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
     * Send Appointment Confirmation (npskgl_appointment_whatsapp).
     *
     * Dynamic variables: {{1}} Parent Name, {{2}} Appointment Date, {{3}} Appointment Time
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendAppointment(
        Lead $lead,
        string $date,
        string $time
    ): array {
        $parentName = $lead->name ?: 'Parent';

        return $this->send($lead, 'appointment', [
            $parentName,
            $date,
            $time,
        ]);
    }

    /**
     * Send Thank You Message (npskgl_thankyou_whatsapp).
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendThankYou(Lead $lead): array
    {
        $parentName = $lead->name ?: 'Parent';

        return $this->send($lead, 'thankyou', [$parentName]);
    }

    /**
     * Send Offer / Promotion Message (npskgl_admission_promotion_whatsapp).
     *
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function sendPromotion(Lead $lead, ?string $academicYear = '2026-2027'): array
    {
        $parentName = $lead->name ?: 'Parent';
        $year = $academicYear ?: '2026-2027';

        return $this->send($lead, 'promotion', [$parentName, $year]);
    }

    /**
     * Dispatch WhatsApp message for a lead using AiSensy API and log to lead_messages.
     *
     * @param  array<int, string>  $templateParams
     * @return array{success: bool, message: string, lead_message?: LeadMessage, error?: string}
     */
    public function send(Lead $lead, string $templateKey, array $templateParams = []): array
    {
        $template = self::TEMPLATES[$templateKey] ?? null;
        if (! $template) {
            return [
                'success' => false,
                'message' => "Unknown WhatsApp template '{$templateKey}'.",
            ];
        }

        // Clean destination number (10 digits)
        $destination = preg_replace('/\D/', '', (string) $lead->phone);
        if (strlen($destination) > 10 && str_starts_with($destination, '91')) {
            $destination = substr($destination, 2);
        }

        if (strlen($destination) !== 10) {
            return [
                'success' => false,
                'message' => "Lead phone '{$lead->phone}' is not a valid 10-digit mobile number.",
            ];
        }

        $renderedText = $this->renderText($templateKey, $templateParams);

        $apiKey = $this->getApiKey();
        $apiUrl = $this->getApiUrl();
        $userName = $this->getUserName();
        $source = $this->getSource();

        // Prepare exact AiSensy JSON payload
        $payload = [
            'apiKey' => $apiKey,
            'campaignName' => $template['campaign'],
            'destination' => $destination,
            'userName' => $userName,
            'templateParams' => array_values($templateParams),
            'source' => $source,
            'media' => (object) [],
            'buttons' => [],
            'carouselCards' => [],
            'location' => (object) [],
            'attributes' => (object) [],
            'paramsFallbackValue' => [
                'FirstName' => $lead->name ?: 'user',
            ],
        ];

        // If no API key configured (local development or sandbox), simulate successful send
        if (empty($apiKey) || $apiKey === '<YOUR_API_KEY>') {
            $leadMessage = LeadMessage::create([
                'lead_id' => $lead->id,
                'channel' => 'whatsapp',
                'template_type' => $templateKey,
                'note' => $renderedText,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            $lead->update([
                'whatsapp_sent_at' => now(),
                'last_contact_at' => now(),
                'status' => $lead->status === 'new' ? 'contacted' : $lead->status,
            ]);

            return [
                'success' => true,
                'message' => "WhatsApp message logged successfully (Simulation/Sandbox mode: {$template['campaign']}).",
                'lead_message' => $leadMessage,
            ];
        }

        try {
            /** @var Response $response */
            $response = Http::timeout(15)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($apiUrl, $payload);

            $isSuccess = $response->successful();
            $responseData = $response->json();

            $status = $isSuccess ? 'sent' : 'failed';
            $errorMessage = $isSuccess ? null : ($responseData['message'] ?? $response->body());

            $leadMessage = LeadMessage::create([
                'lead_id' => $lead->id,
                'channel' => 'whatsapp',
                'template_type' => $templateKey,
                'note' => $isSuccess ? $renderedText : "Error: {$errorMessage} | {$renderedText}",
                'status' => $status,
                'sent_at' => now(),
            ]);

            if ($isSuccess) {
                $lead->update([
                    'whatsapp_sent_at' => now(),
                    'last_contact_at' => now(),
                    'status' => $lead->status === 'new' ? 'contacted' : $lead->status,
                ]);

                return [
                    'success' => true,
                    'message' => 'WhatsApp message delivered successfully via AiSensy.',
                    'lead_message' => $leadMessage,
                ];
            }

            Log::error('AiSensy WhatsApp API error', [
                'lead_id' => $lead->id,
                'payload' => $payload,
                'response' => $responseData,
            ]);

            return [
                'success' => false,
                'message' => 'AiSensy WhatsApp API rejected the request: '.($errorMessage ?: 'Unknown error'),
                'lead_message' => $leadMessage,
                'error' => $errorMessage,
            ];
        } catch (Throwable $e) {
            Log::error('AiSensy WhatsApp connection error', [
                'lead_id' => $lead->id,
                'exception' => $e->getMessage(),
            ]);

            $leadMessage = LeadMessage::create([
                'lead_id' => $lead->id,
                'channel' => 'whatsapp',
                'template_type' => $templateKey,
                'note' => "Connection Exception: {$e->getMessage()} | {$renderedText}",
                'status' => 'failed',
                'sent_at' => now(),
            ]);

            return [
                'success' => false,
                'message' => 'Could not connect to AiSensy WhatsApp API: '.$e->getMessage(),
                'lead_message' => $leadMessage,
                'error' => $e->getMessage(),
            ];
        }
    }
}
