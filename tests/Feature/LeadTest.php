<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_view_leads_index(): void
    {
        $response = $this->get(route('leads.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_user_can_view_leads_index(): void
    {
        $user = User::create([
            'name' => 'AdminUser',
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'mobile_number' => '1234567890',
            'role' => 'admin',
        ]);

        $lead = Lead::create([
            'name' => 'Anand',
            'phone' => '9513477488',
            'city' => 'Anchepalya',
            'source' => 'Google Form',
            'status' => 'new',
        ]);

        $response = $this->actingAs($user)->get(route('leads.index'));

        $response->assertStatus(200);
        $response->assertSee('Anand');
        $response->assertSee('9513477488');
        $response->assertDontSee('<th>Owner</th>', false);
    }

    public function test_authenticated_user_can_view_single_lead(): void
    {
        $user = User::create([
            'name' => 'AdminUser',
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'mobile_number' => '1234567890',
            'role' => 'admin',
        ]);

        $lead = Lead::create([
            'name' => 'Nabila Ruhi',
            'phone' => '9986176580',
            'city' => 'Bengaluru',
            'source' => 'Google Form',
            'status' => 'contacted',
            'interested_in' => 'Grade 1',
        ]);

        $response = $this->actingAs($user)->get(route('leads.view', $lead->id));

        $response->assertStatus(200);
        $response->assertSee('Nabila Ruhi');
        $response->assertSee('9986176580');
        $response->assertSee('Grade 1');
    }

    public function test_user_can_add_note_to_lead(): void
    {
        $user = User::create([
            'name' => 'AdminUser',
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'mobile_number' => '1234567890',
            'role' => 'admin',
        ]);

        $lead = Lead::create([
            'name' => 'Kavitha Ramesh',
            'phone' => '9845011223',
            'source' => 'Meta Leads',
            'status' => 'new',
        ]);

        $response = $this->actingAs($user)->postJson(route('leads.notes.store', $lead->id), [
            'note' => 'Parent called and visited campus.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'note' => [
                'text' => 'Parent called and visited campus.',
                'author' => 'AdminUser',
            ],
        ]);

        $lead->refresh();
        $this->assertIsArray($lead->remarks);
        $this->assertEquals('Parent called and visited campus.', $lead->remarks[0]['text']);
        $this->assertDatabaseHas('lead_messages', [
            'lead_id' => $lead->id,
            'channel' => 'note',
            'note' => 'Parent called and visited campus.',
        ]);
    }

    public function test_user_can_delete_note_from_lead(): void
    {
        $user = User::create([
            'name' => 'AdminUser',
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'mobile_number' => '1234567890',
            'role' => 'admin',
        ]);

        $lead = Lead::create([
            'name' => 'Suresh Babu',
            'phone' => '9972018854',
            'source' => 'Call Leads',
            'status' => 'new',
            'remarks' => [
                ['text' => 'Note 1', 'date' => '21 Nov 2026', 'author' => 'Admin', 'type' => 'note'],
                ['text' => 'Note 2', 'date' => '22 Nov 2026', 'author' => 'Admin', 'type' => 'note'],
            ],
        ]);

        $response = $this->actingAs($user)->deleteJson(route('leads.notes.destroy', ['lead' => $lead->id, 'index' => 0]));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $lead->refresh();
        $this->assertCount(1, $lead->remarks);
        $this->assertEquals('Note 2', $lead->remarks[0]['text']);
    }

    public function test_user_can_update_lead_status(): void
    {
        $user = User::create([
            'name' => 'AdminUser',
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'mobile_number' => '1234567890',
            'role' => 'admin',
        ]);

        $lead = Lead::create([
            'name' => 'Deepak',
            'phone' => '9845012345',
            'source' => 'WhatsApp',
            'status' => 'new',
        ]);

        $response = $this->actingAs($user)->postJson(route('leads.status.update', $lead->id), [
            'status' => 'contacted',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'status' => 'contacted',
        ]);

        $lead->refresh();
        $this->assertEquals('contacted', $lead->status);
        $this->assertNotNull($lead->last_contact_at);
    }
}
