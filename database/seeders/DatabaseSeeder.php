<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            LeaveTypeSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            ContractSeeder::class,
            AttendanceSeeder::class,
            LeaveSeeder::class,
            NoticeSeeder::class,
            EventSeeder::class,
            PayrollSeeder::class,
            AssetSeeder::class,
            AssetAssignmentSeeder::class,
        ]);
    }
}
