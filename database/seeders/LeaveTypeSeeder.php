<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            ['name' => 'Annual Leave', 'max_days_per_year' => 20],
            ['name' => 'Sick Leave', 'max_days_per_year' => 12],
            ['name' => 'Personal Leave', 'max_days_per_year' => 5],
            ['name' => 'Maternity Leave', 'max_days_per_year' => 90],
            ['name' => 'Unpaid Leave', 'max_days_per_year' => 0],
        ];

        foreach ($leaveTypes as $type) {
            DB::table('leave_types')->updateOrInsert(
                ['name' => $type['name']],
                [
                    'max_days_per_year' => $type['max_days_per_year'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
