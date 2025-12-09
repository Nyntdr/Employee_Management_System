<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'name' => 'Human Resource',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Administration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
