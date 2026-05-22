<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role_id' => 1,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'hr@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mike Wilson',
                'email' => 'assistant@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role_id' => $user['role_id'],
                    'is_active' => $user['is_active'],
                    'email_verified_at' => $user['email_verified_at'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
