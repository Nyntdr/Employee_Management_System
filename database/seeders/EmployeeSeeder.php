<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'user_id' => 1,
                'first_name' => 'Admin',
                'last_name' => 'User',
                'gender' => 'male',
                'phone' => '9841000001',
                'secondary_phone' => '9841000001',
                'emergency_contact' => 'Emergency Contact 1',
                'department_id' => 2,
                'date_of_birth' => '1990-01-15',
                'date_of_joining' => '2024-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'gender' => 'female',
                'phone' => '9841000002',
                'secondary_phone' => null,
                'emergency_contact' => 'Emergency Contact 2',
                'department_id' => 1,
                'date_of_birth' => '1992-05-20',
                'date_of_joining' => '2024-03-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'first_name' => 'Mike',
                'last_name' => 'Wilson',
                'gender' => 'male',
                'phone' => '9841000003',
                'secondary_phone' => null,
                'emergency_contact' => 'Emergency Contact 3',
                'department_id' => 1,
                'date_of_birth' => '1995-08-10',
                'date_of_joining' => '2024-06-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'gender' => 'male',
                'phone' => '9841000004',
                'secondary_phone' => '9841000014',
                'emergency_contact' => 'Emergency Contact 4',
                'department_id' => 3,
                'date_of_birth' => '1993-11-25',
                'date_of_joining' => '2024-09-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'gender' => 'female',
                'phone' => '9841000005',
                'secondary_phone' => null,
                'emergency_contact' => 'Emergency Contact 5',
                'department_id' => 4,
                'date_of_birth' => '1991-03-08',
                'date_of_joining' => '2024-02-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
