<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('assets')->insert([
            [
                'asset_code' => 'AST-001',
                'name' => 'Dell Latitude Laptop',
                'type' => 'electronic',
                'category' => 'Computer',
                'brand' => 'Dell',
                'model' => 'Latitude 5440',
                'serial_number' => 'SN-DELL-001',
                'purchase_date' => '2024-01-15',
                'purchase_cost' => 120000.00,
                'warranty_until' => '2027-01-15',
                'status' => 'assigned',
                'current_condition' => 'good',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-002',
                'name' => 'Office Ergonomic Chair',
                'type' => 'furniture',
                'category' => 'Seating',
                'brand' => 'Herman Miller',
                'model' => 'Aeron',
                'serial_number' => 'SN-CHAIR-002',
                'purchase_date' => '2024-02-01',
                'purchase_cost' => 85000.00,
                'warranty_until' => '2029-02-01',
                'status' => 'assigned',
                'current_condition' => 'good',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-003',
                'name' => 'Toyota Camry',
                'type' => 'vehicle',
                'category' => 'Company Car',
                'brand' => 'Toyota',
                'model' => 'Camry 2024',
                'serial_number' => 'SN-CAR-003',
                'purchase_date' => '2024-03-01',
                'purchase_cost' => 3500000.00,
                'warranty_until' => '2028-03-01',
                'status' => 'assigned',
                'current_condition' => 'good',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-004',
                'name' => 'HP LaserJet Printer',
                'type' => 'electronic',
                'category' => 'Printer',
                'brand' => 'HP',
                'model' => 'LaserJet Pro M404',
                'serial_number' => 'SN-HP-004',
                'purchase_date' => '2024-01-10',
                'purchase_cost' => 35000.00,
                'warranty_until' => '2026-01-10',
                'status' => 'available',
                'current_condition' => 'new',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-005',
                'name' => 'Conference Room Table',
                'type' => 'furniture',
                'category' => 'Tables',
                'brand' => 'IKEA',
                'model' => 'BEKANT',
                'serial_number' => 'SN-TABLE-005',
                'purchase_date' => '2024-06-01',
                'purchase_cost' => 45000.00,
                'warranty_until' => '2027-06-01',
                'status' => 'available',
                'current_condition' => 'good',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
