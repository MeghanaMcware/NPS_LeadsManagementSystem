<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\LeadMessage;
use App\Services\WhatsAppService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WhatsAppServiceTest extends TestCase
{
    use RefreshDatabase;

    protected WhatsAppService $service;

    protected Lead $lead;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new WhatsAppService;

        $this->lead = Lead::create([
            'name' => 'Anand Kumar',
            'phone' => '9964827788',
            'city' => 'Bengaluru',
            'email' => 'anand@example.com',
            'interested_in' => 'Grade 1',
            'source' => 'Google Form',
            'status' => 'new',
        ]);
    }

    public function test_all_five_templates_exist_and_render_correctly(): void
    {
        $templates = $this->service->getTemplates();

        $this->assertCount(5, $templates);
        $this->assertArrayHasKey('greeting', $templates);
        $this->assertArrayHasKey('followup', $templates);
        $this->assertArrayHasKey('appointment', $templates);
        $this->assertArrayHasKey('thankyou', $templates);
        $this->assertArrayHasKey('promotion', $templates);

        $this->assertEquals('npskgl_welcome_greeting', $templates['greeting']['campaign']);
        $this->assertEquals('npskgl_followup_whatsapp', $templates['followup']['campaign']);
        $this->assertEquals('npskgl_appointment_whatsapp', $templates['appointment']['campaign']);
        $this->assertEquals('npskgl_thankyou_whatsapp', $templates['thankyou']['campaign']);
        $this->assertEquals('npskgl_admission_promotion_whatsapp', $templates['promotion']['campaign']);

        $rendered = $this->service->renderText('greeting', ['Anand Kumar', 'Aryan Kumar']);
        $this->assertStringContainsString('Hello Anand Kumar! 👋', $rendered);
        $this->assertStringContainsString('admission enquiry for Aryan Kumar', $rendered);
    }

    public function test_send_greeting_success_with_http_mock(): void
    {
        Config::set('services.aisensy.api_key', 'test_key_123');

        Http::fake([
            'https://backend.api-wa.co/*' => Http::response([
                'success' => true,
                'message' => 'Campaign initiated successfully',
            ], 200),
        ]);

        $result = $this->service->sendGreeting($this->lead, 'Aryan Kumar');

        $this->assertTrue($result['success']);
        $this->assertInstanceOf(LeadMessage::class, $result['lead_message']);

        // Assert message recorded in database
        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'whatsapp',
            'template_type' => 'greeting',
            'status' => 'sent',
        ]);

        // Assert lead contact timestamps and status updated
        $this->lead->refresh();
        $this->assertNotNull($this->lead->whatsapp_sent_at);
        $this->assertNotNull($this->lead->last_contact_at);
        $this->assertEquals('contacted', $this->lead->status);

        // Verify sent HTTP payload
        Http::assertSent(function ($request) {
            $data = $request->data();

            return $request->url() === 'https://backend.api-wa.co/campaign/mcware/api/v2'
                && $data['apiKey'] === 'test_key_123'
                && $data['campaignName'] === 'npskgl_welcome_greeting'
                && $data['destination'] === '9964827788'
                && $data['templateParams'] === ['Anand Kumar', 'Aryan Kumar'];
        });
    }

    public function test_send_appointment_confirmation(): void
    {
        Config::set('services.aisensy.api_key', 'test_key_123');

        Http::fake([
            'https://backend.api-wa.co/*' => Http::response(['success' => true], 200),
        ]);

        $result = $this->service->sendAppointment(
            $this->lead,
            'Aryan',
            'Grade 2',
            '25 Nov 2026',
            '10:30 AM'
        );

        $this->assertTrue($result['success']);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'whatsapp',
            'template_type' => 'appointment',
            'status' => 'sent',
        ]);

        Http::assertSent(function ($request) {
            $data = $request->data();

            return $data['campaignName'] === 'npskgl_appointment_whatsapp'
                && $data['templateParams'] === ['Anand Kumar', 'Aryan', 'Grade 2', '25 Nov 2026', '10:30 AM'];
        });
    }

    public function test_send_fails_gracefully_when_api_rejects(): void
    {
        Config::set('services.aisensy.api_key', 'test_key_123');

        Http::fake([
            'https://backend.api-wa.co/*' => Http::response([
                'success' => false,
                'message' => 'Invalid destination number or template parameter count',
            ], 400),
        ]);

        $result = $this->service->sendFollowup($this->lead);

        $this->assertFalse($result['success']);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'whatsapp',
            'template_type' => 'followup',
            'status' => 'failed',
        ]);
    }

    public function test_send_fails_on_invalid_phone_number(): void
    {
        $this->lead->update(['phone' => '123']);

        $result = $this->service->sendThankYou($this->lead);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('not a valid 10-digit mobile number', $result['message']);
    }

    public function test_simulation_mode_without_api_key(): void
    {
        Config::set('services.aisensy.api_key', '');

        $result = $this->service->sendPromotion($this->lead, '2026-2027');

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('Simulation/Sandbox mode', $result['message']);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $this->lead->id,
            'channel' => 'whatsapp',
            'template_type' => 'promotion',
            'status' => 'sent',
        ]);
    }
}
