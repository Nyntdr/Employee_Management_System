<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => 'Annual Company Picnic',
                'description' => 'Annual company-wide picnic at Riverside Park. Food and games included.',
                'event_date' => '2026-07-15',
                'start_time' => '10:00:00',
                'end_time' => '16:00:00',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Quarterly Review Meeting',
                'description' => 'Q2 performance review meeting for all department heads.',
                'event_date' => '2026-06-30',
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Team Building Workshop',
                'description' => 'Interactive workshop focused on communication and collaboration.',
                'event_date' => '2026-06-20',
                'start_time' => '13:00:00',
                'end_time' => '17:00:00',
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Technical Training Session',
                'description' => 'Training on new software tools and best practices for the IT team.',
                'event_date' => '2026-06-25',
                'start_time' => '10:00:00',
                'end_time' => '15:00:00',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Monthly Birthday Celebration',
                'description' => 'Celebrating birthdays of all staff born in June. Cake and refreshments provided.',
                'event_date' => '2026-06-18',
                'start_time' => '15:30:00',
                'end_time' => '16:30:00',
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
