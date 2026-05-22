<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Human Resources'],
            ['name' => 'Information Technology'],
            ['name' => 'Finance & Accounting'],
            ['name' => 'Marketing'],
            ['name' => 'Operations'],
        ];

        foreach ($departments as $dept) {
            DB::table('departments')->updateOrInsert(
                ['name' => $dept['name']],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
