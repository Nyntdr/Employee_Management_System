<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id('asset_id');
            $table->string('asset_code',50)->unique();
            $table->string('name',100);
            $table->enum('type',['electronic','furniture','vehicle','stationery','other']);
            $table->string('category',100)->nullable();
            $table->string('brand',100)->nullable();
            $table->string('model',100)->nullable();
            $table->string('serial_number',100)->unique();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 12, 2)->nullable();
            $table->date('warranty_until')->nullable();
            $table->enum('status', ['available', 'assigned', 'under_repair', 'disposed', 'lost'])->default('available');
            $table->enum('current_condition', ['new', 'good', 'fair', 'poor', 'damaged'])->default('new');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
