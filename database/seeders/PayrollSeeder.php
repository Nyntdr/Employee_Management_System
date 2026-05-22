<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayrollSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payrolls')->insert([
            [
                'employee_id' => 1,
                'month_year' => '2026-05',
                'basic_salary' => 80000.00,
                'overtime_pay' => 5000.00,
                'bonus' => 10000.00,
                'deductions' => 3000.00,
                'net_salary' => 92000.00,
                'payment_status' => 'paid',
                'paid_date' => '2026-05-28',
                'generated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'month_year' => '2026-05',
                'basic_salary' => 65000.00,
                'overtime_pay' => 2000.00,
                'bonus' => 5000.00,
                'deductions' => 2500.00,
                'net_salary' => 69500.00,
                'payment_status' => 'paid',
                'paid_date' => '2026-05-28',
                'generated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 3,
                'month_year' => '2026-05',
                'basic_salary' => 45000.00,
                'overtime_pay' => 0.00,
                'bonus' => 2000.00,
                'deductions' => 1500.00,
                'net_salary' => 45500.00,
                'payment_status' => 'paid',
                'paid_date' => '2026-05-28',
                'generated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 4,
                'month_year' => '2026-05',
                'basic_salary' => 55000.00,
                'overtime_pay' => 0.00,
                'bonus' => 0.00,
                'deductions' => 2000.00,
                'net_salary' => 53000.00,
                'payment_status' => 'pending',
                'paid_date' => null,
                'generated_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 5,
                'month_year' => '2026-05',
                'basic_salary' => 60000.00,
                'overtime_pay' => 1500.00,
                'bonus' => 3000.00,
                'deductions' => 2200.00,
                'net_salary' => 62300.00,
                'payment_status' => 'pending',
                'paid_date' => null,
                'generated_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
