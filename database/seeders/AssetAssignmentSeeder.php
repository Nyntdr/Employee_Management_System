<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('asset_assignments')->insert([
            [
                'asset_id' => 1,
                'employee_id' => 1,
                'assigned_by' => 1,
                'assigned_date' => '2026-01-15',
                'returned_date' => null,
                'status' => 'active',
                'purpose' => 'Primary work laptop',
                'condition_at_assignment' => 'good',
                'condition_at_return' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 2,
                'employee_id' => 5,
                'assigned_by' => 2,
                'assigned_date' => '2026-02-01',
                'returned_date' => null,
                'status' => 'active',
                'purpose' => 'Ergonomic chair for office use',
                'condition_at_assignment' => 'good',
                'condition_at_return' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 3,
                'employee_id' => 2,
                'assigned_by' => 1,
                'assigned_date' => '2026-03-01',
                'returned_date' => null,
                'status' => 'active',
                'purpose' => 'Company vehicle for HR department',
                'condition_at_assignment' => 'new',
                'condition_at_return' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 1,
                'employee_id' => 4,
                'assigned_by' => 1,
                'assigned_date' => '2025-11-01',
                'returned_date' => '2026-01-10',
                'status' => 'returned',
                'purpose' => 'Temporary assignment for contractor',
                'condition_at_assignment' => 'good',
                'condition_at_return' => 'good',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 5,
                'employee_id' => 3,
                'assigned_by' => 1,
                'assigned_date' => '2026-04-01',
                'returned_date' => null,
                'status' => 'active',
                'purpose' => 'Shared conference room equipment management',
                'condition_at_assignment' => 'good',
                'condition_at_return' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
