<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('leaves')->insert([
            [
                'employee_id' => 4,
                'leave_type_id' => 1,
                'start_date' => '2026-06-01',
                'end_date' => '2026-06-05',
                'reason' => 'Family vacation',
                'status' => 'approved',
                'approved_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 5,
                'leave_type_id' => 2,
                'start_date' => '2026-06-10',
                'end_date' => '2026-06-11',
                'reason' => 'Doctor appointment',
                'status' => 'pending',
                'approved_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 4,
                'leave_type_id' => 3,
                'start_date' => '2026-05-20',
                'end_date' => '2026-05-20',
                'reason' => 'Personal errand',
                'status' => 'approved',
                'approved_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 5,
                'leave_type_id' => 1,
                'start_date' => '2026-07-01',
                'end_date' => '2026-07-10',
                'reason' => 'International trip',
                'status' => 'rejected',
                'approved_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 3,
                'leave_type_id' => 2,
                'start_date' => '2026-06-15',
                'end_date' => '2026-06-16',
                'reason' => 'Medical leave',
                'status' => 'pending',
                'approved_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
