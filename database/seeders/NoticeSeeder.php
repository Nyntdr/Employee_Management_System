<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoticeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notices')->insert([
            [
                'title' => 'Company Holiday Announcement',
                'content' => 'The office will remain closed on June 15th for the annual company holiday.',
                'posted_by' => 1,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Updated HR Policy',
                'content' => 'Please review the updated work-from-home policy document attached in the portal.',
                'posted_by' => 1,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Team Building Event',
                'content' => 'We are organizing a team building event on June 20th. Attendance is mandatory for all staff.',
                'posted_by' => 2,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'System Maintenance Notice',
                'content' => 'The server will be down for maintenance on Saturday from 10 PM to 2 AM.',
                'posted_by' => 1,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Welcome New Employees',
                'content' => 'Please join us in welcoming our new team members joining this month.',
                'posted_by' => 2,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
