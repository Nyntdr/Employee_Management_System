<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
    'user_id'           => 3,
    'first_name'        => 'Nayan',
    'last_name'         => 'Tandukar',
    'gender'            => 'male',
    'phone'             => '9843949573',
    'secondary_phone'   => '9763439493',
    'emergency_contact' => 'Sagar Tandukar (Dad - 9841308955)',
    'department_id'     => 2, 
    'position'          => 'Administrator',
    'date_of_birth'     => '2003-09-24',
    'date_of_joining'   => '2025-10-20',
    'employment_status' => 'active',
    'created_at'        => now(),
    'updated_at'        => now(),
]);
    }
}
