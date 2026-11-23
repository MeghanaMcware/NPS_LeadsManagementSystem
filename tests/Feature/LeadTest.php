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
}
