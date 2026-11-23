<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsAppLeadApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_whatsapp_lead_with_all_four_fields(): void
    {
        $response = $this->postJson('/api/leads/whatsapp', [
            'parent_name' => 'Smitha Kurup',
            'mobile_number' => 'p:+919164432664',
            'email' => 'smithakurup04@gmail.com',
            'grade' => 'Grade 5',
        ]);

        $response->assertCreated();
        $response->assertJson([
            'success' => true,
            'message' => 'WhatsApp lead created successfully.',
            'lead' => [
                'name' => 'Smitha Kurup',
                'phone' => '9164432664',
                'email' => 'smithakurup04@gmail.com',
                'interested_in' => 'Grade 5',
                'source' => 'WhatsApp Chatbot',
                'status' => 'new',
            ],
        ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'Smitha Kurup',
            'phone' => '9164432664',
            'email' => 'smithakurup04@gmail.com',
            'interested_in' => 'Grade 5',
            'source' => 'WhatsApp Chatbot',
            'status' => 'new',
        ]);
    }

    public function test_can_store_whatsapp_lead_with_only_mobile_number(): void
    {
        $response = $this->postJson('/api/whatsapp/lead', [
            'phone' => '+91 9901942115',
        ]);

        $response->assertCreated();
        $response->assertJson([
            'success' => true,
            'lead' => [
                'name' => 'WhatsApp Lead',
                'phone' => '9901942115',
                'email' => null,
                'interested_in' => null,
                'source' => 'WhatsApp Chatbot',
            ],
        ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'WhatsApp Lead',
            'phone' => '9901942115',
            'source' => 'WhatsApp Chatbot',
            'email' => null,
            'city' => null,
            'remarks' => null,
        ]);
    }

    public function test_updating_existing_lead_when_chatbot_submits_more_details(): void
    {
        Lead::create([
            'name' => 'Initial Lead',
            'phone' => '9164432664',
            'source' => 'WhatsApp',
            'status' => 'new',
        ]);

        $response = $this->postJson('/api/leads/whatsapp', [
            'name' => 'Smitha Kurup',
            'phone' => '9164432664',
            'grade' => 'Grade 5',
            'email' => 'smithakurup04@gmail.com',
        ]);

        $response->assertOk();
        $this->assertEquals(1, Lead::query()->where('phone', '9164432664')->count());

        $this->assertDatabaseHas('leads', [
            'phone' => '9164432664',
            'name' => 'Smitha Kurup',
            'interested_in' => 'Grade 5',
            'email' => 'smithakurup04@gmail.com',
            'source' => 'WhatsApp',
        ]);
    }

    public function test_missing_phone_returns_422(): void
    {
        $response = $this->postJson('/api/leads/whatsapp', [
            'parent_name' => 'No Phone Parent',
            'grade' => 'UKG',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['phone']);
    }
}
