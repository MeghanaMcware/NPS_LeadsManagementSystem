<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'AdminUser',
                'mobile_number' => '1234567890',
                'role' => 'admin',
                'password' => Hash::make('123456'),
            ]
        );

        $sampleLeads = [
            [
                'name' => 'Anand',
                'phone' => '9513477488',
                'city' => 'Anchepalya',
                'interested_in' => 'Grade 1',
                'remarks' => 'He will take admission. Payment done.',
                'source' => 'Google Form',
                'status' => 'converted',
                'last_contact_at' => now()->subHours(2),
                'whatsapp_sent_at' => now()->subHours(2),
            ],
            [
                'name' => 'Nabila Ruhi',
                'phone' => '9986176580',
                'city' => 'Bengaluru',
                'interested_in' => 'Grade 1',
                'remarks' => 'Not Answering',
                'source' => 'Google Form',
                'status' => 'contacted',
                'last_contact_at' => now()->subDay(),
                'whatsapp_sent_at' => now()->subDay(),
            ],
            [
                'name' => 'Durgamma',
                'phone' => '9900872991',
                'city' => 'Bengaluru',
                'interested_in' => 'Job Enquiry',
                'remarks' => 'sent Resume',
                'source' => 'WhatsApp',
                'status' => 'contacted',
                'last_contact_at' => now()->subDays(2),
                'whatsapp_sent_at' => null,
            ],
            [
                'name' => 'Amit',
                'phone' => '8884402809',
                'city' => 'Bengaluru',
                'interested_in' => 'Football Coach',
                'remarks' => 'inquiry for football coach',
                'source' => 'WhatsApp',
                'status' => 'followup',
                'last_contact_at' => now()->subDays(3),
                'whatsapp_sent_at' => now()->subDays(3),
            ],
            [
                'name' => 'Venkatesh',
                'phone' => '9902760106',
                'city' => 'Bengaluru',
                'interested_in' => 'Call for Tank Clean',
                'remarks' => 'Call for Tank Clean',
                'source' => 'WhatsApp',
                'status' => 'new',
                'last_contact_at' => null,
                'whatsapp_sent_at' => null,
            ],
            [
                'name' => 'Diya Biju',
                'phone' => '8825964695',
                'city' => 'Bengaluru',
                'interested_in' => 'Enquired for Bangalore International School',
                'remarks' => 'Enquiry for grade admission',
                'source' => 'Google Form',
                'status' => 'new',
                'last_contact_at' => null,
                'whatsapp_sent_at' => null,
            ],
        ];

        foreach ($sampleLeads as $data) {
            Lead::query()->updateOrCreate(
                ['phone' => $data['phone']],
                $data
            );
        }
    }
}
