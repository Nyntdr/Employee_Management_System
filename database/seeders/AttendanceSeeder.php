<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('attendances')->insert([
            [
                'employee_id' => 1,
                'date' => now()->subDays(1)->format('Y-m-d'),
                'clock_in' => '08:45:00',
                'clock_out' => '17:15:00',
                'total_hours' => '08:30:00',
                'status' => 'present',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'date' => now()->subDays(1)->format('Y-m-d'),
                'clock_in' => '09:00:00',
                'clock_out' => '17:30:00',
                'total_hours' => '08:30:00',
                'status' => 'present',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 3,
                'date' => now()->subDays(1)->format('Y-m-d'),
                'clock_in' => '09:45:00',
                'clock_out' => '17:00:00',
                'total_hours' => '07:15:00',
                'status' => 'late',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 4,
                'date' => now()->subDays(2)->format('Y-m-d'),
                'clock_in' => '08:30:00',
                'clock_out' => '17:00:00',
                'total_hours' => '08:30:00',
                'status' => 'present',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 5,
                'date' => now()->subDays(2)->format('Y-m-d'),
                'clock_in' => '08:15:00',
                'clock_out' => '16:45:00',
                'total_hours' => '08:30:00',
                'status' => 'present',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
