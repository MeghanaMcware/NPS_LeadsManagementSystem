<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SendMessageTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'admin',
        ]);

        Config::set('services.aisensy.api_key', 'test-aisensy-key');
        Config::set('services.aisensy.api_url', 'https://backend.api-wa.co/campaign/mcware/api/v2');
        Config::set('services.brevo.api_key', 'test-brevo-key');
        Config::set('services.brevo.sms_url', 'https://api.brevo.com/v3/transactionalSMS/sms');
        Config::set('services.brevo.email_url', 'https://api.brevo.com/v3/smtp/email');
    }

    public function test_send_message_page_requires_authentication(): void
    {
        $response = $this->get(route('messages.send'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_send_message_page_renders_successfully(): void
    {
        Lead::create([
            'name' => 'Kavitha Ramesh',
            'phone' => '9845011223',
            'email' => 'kavitha@example.com',
            'interested_in' => 'Grade 4',
            'source' => 'Website',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->user)->get(route('messages.send'));

        $response->assertStatus(200);
        $response->assertSee('Send Message');
        $response->assertSee('WhatsApp');
        $response->assertSee('SMS');
        $response->assertSee('Email');
        $response->assertViewHas('selectedIds', []);
    }

    public function test_send_message_page_preselects_lead_when_navigated_from_leads_page(): void
    {
        $lead1 = Lead::create([
            'name' => 'First Parent',
            'phone' => '9845011111',
            'interested_in' => 'Grade 1',
            'source' => 'Website',
            'status' => 'new',
        ]);

        $lead2 = Lead::create([
            'name' => 'Target Parent',
            'phone' => '9845022222',
            'interested_in' => 'Grade 2',
            'source' => 'Website',
            'status' => 'new',
        ]);

        // When navigated from leads page with single lead_id
        $responseSingle = $this->actingAs($this->user)->get(route('messages.send', ['lead_id' => $lead2->id]));
        $responseSingle->assertStatus(200);
        $responseSingle->assertViewHas('selectedIds', [$lead2->id]);

        // When navigated from leads page with multiple lead_ids
        $responseMulti = $this->actingAs($this->user)->get(route('messages.send', ['lead_ids' => "{$lead1->id},{$lead2->id}"]));
        $responseMulti->assertStatus(200);
        $responseMulti->assertViewHas('selectedIds', [$lead1->id, $lead2->id]);
    }

    public function test_old_url_redirects_to_messages_send_preserving_query(): void
    {
        $response = $this->actingAs($this->user)->get('/sendmessage/index?lead_id=42');

        $response->assertRedirect(route('messages.send', ['lead_id' => 42]));
    }

    public function test_dispatch_whatsapp_message_successfully(): void
    {
        Http::fake([
            'https://backend.api-wa.co/*' => Http::response(['success' => true, 'message' => 'Sent successfully'], 200),
        ]);

        $lead = Lead::create([
            'name' => 'Sanjay Sharma',
            'phone' => '9845033333',
            'interested_in' => 'Grade 5',
            'source' => 'WhatsApp Chatbot',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->user)->postJson(route('messages.send.dispatch'), [
            'channel' => 'whatsapp',
            'template_key' => 'greeting',
            'lead_ids' => [$lead->id],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'sent_count' => 1,
            'failed_count' => 0,
        ]);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $lead->id,
            'channel' => 'whatsapp',
            'template_type' => 'greeting',
            'status' => 'sent',
        ]);
    }

    public function test_dispatch_sms_message_successfully(): void
    {
        Http::fake([
            'https://api.brevo.com/v3/transactionalSMS/sms' => Http::response(['messageId' => 'sms_test_999'], 201),
        ]);

        $lead = Lead::create([
            'name' => 'Pooja Hegde',
            'phone' => '9845044444',
            'interested_in' => 'Grade 3',
            'source' => 'Website',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->user)->postJson(route('messages.send.dispatch'), [
            'channel' => 'sms',
            'template_key' => 'followup',
            'lead_ids' => [$lead->id],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'sent_count' => 1,
            'failed_count' => 0,
        ]);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $lead->id,
            'channel' => 'sms',
            'template_type' => 'followup',
            'status' => 'sent',
        ]);
    }

    public function test_dispatch_email_message_successfully(): void
    {
        Http::fake([
            'https://api.brevo.com/v3/smtp/email' => Http::response(['messageId' => '<mail_test_888@brevo.com>'], 201),
        ]);

        $lead = Lead::create([
            'name' => 'Deepak Verma',
            'phone' => '9845055555',
            'email' => 'deepak@example.com',
            'interested_in' => 'Grade 8',
            'source' => 'Website',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->user)->postJson(route('messages.send.dispatch'), [
            'channel' => 'email',
            'template_key' => 'appointment',
            'lead_ids' => [$lead->id],
            'visit_date' => '30 Nov 2026',
            'visit_time' => '11:00 AM',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'sent_count' => 1,
            'failed_count' => 0,
        ]);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $lead->id,
            'channel' => 'email',
            'template_type' => 'appointment',
            'status' => 'sent',
        ]);
    }

    public function test_dispatch_validation_fails_on_missing_fields(): void
    {
        $response = $this->actingAs($this->user)->postJson(route('messages.send.dispatch'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['channel', 'template_key', 'lead_ids']);
    }
}
