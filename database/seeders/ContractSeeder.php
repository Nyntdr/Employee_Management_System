<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contracts')->insert([
            [
                'employee_id' => 1,
                'contract_type' => 'full_time',
                'job_title' => 'administrator',
                'start_date' => '2024-01-01',
                'end_date' => null,
                'probation_period' => 3,
                'salary' => 80000.00,
                'contract_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'contract_type' => 'full_time',
                'job_title' => 'human_resource',
                'start_date' => '2024-03-15',
                'end_date' => null,
                'probation_period' => 3,
                'salary' => 65000.00,
                'contract_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 3,
                'contract_type' => 'full_time',
                'job_title' => 'hr_assistant',
                'start_date' => '2024-06-01',
                'end_date' => null,
                'probation_period' => 3,
                'salary' => 45000.00,
                'contract_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 4,
                'contract_type' => 'full_time',
                'job_title' => 'accountant',
                'start_date' => '2024-09-01',
                'end_date' => null,
                'probation_period' => 3,
                'salary' => 55000.00,
                'contract_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 5,
                'contract_type' => 'part_time',
                'job_title' => 'marketing_manager',
                'start_date' => '2024-02-01',
                'end_date' => '2026-12-31',
                'probation_period' => 2,
                'salary' => 60000.00,
                'contract_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
