<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FrontendEnquiryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('services.aisensy.api_key', ''); // Simulation mode
        Config::set('services.brevo.api_key', 'xkeysib-dummy-test'); // Simulation mode
    }

    public function test_submitting_enquiry_creates_lead_in_database_and_logs_whatsapp_greeting(): void
    {
        $response = $this->postJson(route('frontend.enquiry.submit'), [
            'parent_name' => 'Rajesh Sharma',
            'mobile_number' => '9845012345',
            'email' => 'rajesh@example.com',
            'grade' => 'Grade 2',
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'Thank you. Our admissions team will get in touch with you shortly.',
        ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'Rajesh Sharma',
            'phone' => '9845012345',
            'email' => 'rajesh@example.com',
            'interested_in' => 'Grade 2',
            'source' => 'Website',
        ]);

        $lead = Lead::query()->where('phone', '9845012345')->first();
        $this->assertNotNull($lead);
        $this->assertNotNull($lead->whatsapp_sent_at);

        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $lead->id,
            'channel' => 'whatsapp',
            'template_type' => 'greeting',
            'status' => 'sent',
        ]);
    }

    public function test_submitting_duplicate_phone_updates_existing_lead(): void
    {
        Lead::create([
            'name' => 'Initial Parent',
            'phone' => '9845012345',
            'interested_in' => 'Nursery',
            'source' => 'Website',
            'status' => 'new',
        ]);

        $response = $this->postJson(route('frontend.enquiry.submit'), [
            'parent_name' => 'Updated Parent Name',
            'mobile_number' => '9845012345',
            'email' => 'updated@example.com',
            'grade' => 'LKG',
        ]);

        $response->assertOk();

        $this->assertEquals(1, Lead::query()->where('phone', '9845012345')->count());

        $this->assertDatabaseHas('leads', [
            'phone' => '9845012345',
            'name' => 'Updated Parent Name',
            'email' => 'updated@example.com',
            'interested_in' => 'LKG',
            'source' => 'Website',
        ]);
    }

    public function test_submitting_with_invalid_phone_fails_validation(): void
    {
        $response = $this->postJson(route('frontend.enquiry.submit'), [
            'parent_name' => 'Rajesh',
            'mobile_number' => '12345', // Invalid
            'grade' => 'Grade 1',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mobile_number']);
    }
}
