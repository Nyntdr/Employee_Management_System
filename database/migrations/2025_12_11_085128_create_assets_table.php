<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\AssetTypes;
use App\Enums\AssetStatuses;
use App\Enums\AssetConditions;

return new class extends Migration
{
    public function up(): void
    {
        $types = array_column(AssetTypes::cases(), 'value');
        $statuses = array_column(AssetStatuses::cases(), 'value');
        $conditions = array_column(AssetConditions::cases(), 'value');

        Schema::create('assets', function (Blueprint $table) use ($types, $statuses, $conditions) {
            $table->id('asset_id');
            $table->string('asset_code', 50)->unique();
            $table->string('name', 150);
            $table->enum('type', $types);
            $table->string('category', 100)->nullable();
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 100)->unique();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 12, 2)->nullable();
            $table->date('warranty_until')->nullable();
            $table->enum('status', $statuses)->default(AssetStatuses::AVAILABLE->value);
            $table->enum('current_condition', $conditions)->default(AssetConditions::NEW->value);
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};