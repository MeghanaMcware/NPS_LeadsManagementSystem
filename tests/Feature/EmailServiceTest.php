<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Services\EmailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class EmailServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EmailService $service;

    protected Lead $lead;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new EmailService;

        $this->lead = Lead::create([
            'name' => 'Suresh Raina',
            'phone' => '9845098450',
            'email' => 'suresh@example.com',
            'interested_in' => 'Grade 3',
            'source' => 'Website',
            'status' => 'new',
        ]);
    }

    public function test_all_five_email_blade_views_render_properly(): void
    {
        $templates = [
            'emails.welcome_greeting',
            'emails.followup',
            'emails.appointment_confirmation',
            'emails.thank_you',
            'emails.admission_promotion',
        ];

        $data = [
            'parentName' => 'Suresh Raina',
            'studentName' => 'Priyansh Raina',
            'grade' => 'Grade 3',
            'academicYear' => '2027-28',
            'appointmentDate' => '28 Nov 2026',
            'appointmentTime' => '11:00 AM',
        ];

        foreach ($templates as $view) {
            $html = view($view, $data)->render();
            $this->assertNotEmpty($html);
            $this->assertStringContainsString('National Public School', $html);
        }
    }

    public function test_simulation_mode_with_dummy_api_key(): void
    {
        Config::set('services.brevo.api_key', 'xkeysib-dummy-api-key-replace-with-your-real-key');

        $result = $this->service->sendGreeting($this->lead);

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('Brevo Simulation Mode', $result['message']);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'email',
            'template_type' => 'greeting',
            'status' => 'sent',
        ]);

        $this->lead->refresh();
        $this->assertNotNull($this->lead->email_sent_at);
        $this->assertEquals('contacted', $this->lead->status);
    }

    public function test_live_api_dispatch_with_http_mock(): void
    {
        Config::set('services.brevo.api_key', 'real_live_brevo_key_abc123');

        Http::fake([
            'https://api.brevo.com/v3/smtp/email' => Http::response([
                'messageId' => '<202611231610.1234567@smtp-relay.brevo.com>',
            ], 201),
        ]);

        $result = $this->service->sendAppointment(
            $this->lead,
            'Priyansh Raina',
            'Grade 3',
            '30 Nov 2026',
            '10:00 AM'
        );

        $this->assertTrue($result['success']);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'email',
            'template_type' => 'appointment',
            'status' => 'sent',
        ]);

        Http::assertSent(function ($request) {
            $data = $request->data();

            return $request->url() === 'https://api.brevo.com/v3/smtp/email'
                && $request->header('api-key')[0] === 'real_live_brevo_key_abc123'
                && $data['to'][0]['email'] === 'suresh@example.com'
                && $data['subject'] === 'Campus Visit Appointment Confirmed – NPS KGL'
                && str_contains($data['htmlContent'], 'Priyansh Raina');
        });
    }

    public function test_api_handles_rejection_gracefully(): void
    {
        Config::set('services.brevo.api_key', 'real_live_brevo_key_abc123');

        Http::fake([
            'https://api.brevo.com/v3/smtp/email' => Http::response([
                'code' => 'invalid_parameter',
                'message' => 'Sender email not verified',
            ], 400),
        ]);

        $result = $this->service->sendFollowup($this->lead);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Sender email not verified', $result['message']);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'email',
            'template_type' => 'followup',
            'status' => 'failed',
        ]);
    }

    public function test_email_fails_when_lead_has_no_email(): void
    {
        $this->lead->update(['email' => null]);

        $result = $this->service->sendThankYou($this->lead);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('no valid email', $result['message']);
    }

    public function test_frontend_enquiry_triggers_both_whatsapp_and_email(): void
    {
        Config::set('services.aisensy.api_key', ''); // Simulation mode
        Config::set('services.brevo.api_key', 'xkeysib-dummy-test'); // Simulation mode

        $response = $this->postJson(route('frontend.enquiry.submit'), [
            'parent_name' => 'Meena Sharma',
            'mobile_number' => '9845012399',
            'email' => 'meena@example.com',
            'grade' => 'Grade 1',
        ]);

        $response->assertOk();

        $lead = Lead::query()->where('phone', '9845012399')->first();
        $this->assertNotNull($lead);
        $this->assertNotNull($lead->whatsapp_sent_at);
        $this->assertNotNull($lead->email_sent_at);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $lead->id,
            'channel' => 'whatsapp',
            'template_type' => 'greeting',
            'status' => 'sent',
        ]);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $lead->id,
            'channel' => 'email',
            'template_type' => 'greeting',
            'status' => 'sent',
        ]);
    }
}
