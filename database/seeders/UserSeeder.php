<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('users')->insert([
            [
                'email' => 'admin@example.com',
                'name' => 'Admin',
                'password' => Hash::make('admin123'), 
                'role_id' => 1,  
                'is_active' => true,
                'last_login' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


