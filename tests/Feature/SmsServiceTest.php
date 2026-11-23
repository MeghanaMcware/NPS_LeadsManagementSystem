<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Services\SmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SmsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected SmsService $service;

    protected Lead $lead;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new SmsService;

        $this->lead = Lead::create([
            'name' => 'Anand Kumar',
            'phone' => '9964827788',
            'city' => 'Bengaluru',
            'email' => 'anand@example.com',
            'interested_in' => 'Grade 1',
            'source' => 'Website',
            'status' => 'new',
        ]);
    }

    public function test_all_five_sms_templates_exist_and_render_correctly(): void
    {
        $templates = $this->service->getTemplates();

        $this->assertCount(5, $templates);
        $this->assertArrayHasKey('greeting', $templates);
        $this->assertArrayHasKey('followup', $templates);
        $this->assertArrayHasKey('appointment', $templates);
        $this->assertArrayHasKey('thankyou', $templates);
        $this->assertArrayHasKey('promotion', $templates);

        $greetingText = $this->service->renderText('greeting', ['Anand Kumar', 'Grade 1']);
        $this->assertStringContainsString('Dear Anand Kumar', $greetingText);
        $this->assertStringContainsString('enquiry at National Public School – Kempegowda Layout (NPS KGL) for Grade 1', $greetingText);

        $followupText = $this->service->renderText('followup', ['Anand Kumar']);
        $this->assertStringContainsString('Dear Anand Kumar, this is a gentle reminder', $followupText);

        $appointmentText = $this->service->renderText('appointment', ['Anand Kumar', '28 Nov 2026', '10:30 AM']);
        $this->assertStringContainsString('confirmed on 28 Nov 2026 at 10:30 AM', $appointmentText);

        $thankYouText = $this->service->renderText('thankyou', ['Anand Kumar']);
        $this->assertStringContainsString('thank you for visiting NPS KGL', $thankYouText);

        $promotionText = $this->service->renderText('promotion');
        $this->assertStringContainsString('Admissions Open at National Public School – Kempegowda Layout (NPS KGL)', $promotionText);
    }

    public function test_sms_simulation_mode_with_dummy_api_key(): void
    {
        Config::set('services.brevo.api_key', 'xkeysib-dummy-api-key-replace-with-your-real-key');

        $result = $this->service->sendGreeting($this->lead);

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('Brevo SMS Simulation Mode', $result['message']);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'sms',
            'template_type' => 'greeting',
            'status' => 'sent',
        ]);

        $this->lead->refresh();
        $this->assertNotNull($this->lead->sms_sent_at);
        $this->assertEquals('contacted', $this->lead->status);
    }

    public function test_live_brevo_sms_dispatch_with_http_mock(): void
    {
        Config::set('services.brevo.api_key', 'real_live_brevo_key_xyz123');

        Http::fake([
            'https://api.brevo.com/v3/transactionalSMS/sms' => Http::response([
                'reference' => 'sms_msg_987654',
                'usedCredits' => 1,
            ], 201),
        ]);

        $result = $this->service->sendAppointment($this->lead, '30 Nov 2026', '11:00 AM');

        $this->assertTrue($result['success']);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'sms',
            'template_type' => 'appointment',
            'status' => 'sent',
        ]);

        Http::assertSent(function ($request) {
            $data = $request->data();

            return $request->url() === 'https://api.brevo.com/v3/transactionalSMS/sms'
                && $request->header('api-key')[0] === 'real_live_brevo_key_xyz123'
                && $data['recipient'] === '919964827788'
                && $data['sender'] === 'NPSKGL'
                && str_contains($data['content'], 'confirmed on 30 Nov 2026 at 11:00 AM');
        });
    }

    public function test_brevo_sms_api_rejection_logged_as_failed(): void
    {
        Config::set('services.brevo.api_key', 'real_live_brevo_key_xyz123');

        Http::fake([
            'https://api.brevo.com/v3/transactionalSMS/sms' => Http::response([
                'code' => 'unauthorized',
                'message' => 'Key not authorized for SMS credits',
            ], 403),
        ]);

        $result = $this->service->sendFollowup($this->lead);

        $this->assertFalse($result['success']);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'sms',
            'template_type' => 'followup',
            'status' => 'failed',
        ]);
    }

    public function test_sms_fails_on_invalid_phone_number(): void
    {
        $this->lead->update(['phone' => '123']);

        $result = $this->service->sendThankYou($this->lead);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('not a valid mobile number', $result['message']);
    }
}
