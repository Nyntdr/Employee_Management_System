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
        Schema::create('asset_assignments', function (Blueprint $table) {
            $table->id('assignment_id');
            $table->foreignId('asset_id')->constrained('assets','asset_id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('employee_id')->constrained('employees','employee_id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('restrict');
            $table->date('assigned_date');
            $table->date('returned_date')->nullable();
            $table->enum('status', ['active', 'returned', 'lost', 'damaged'])->default('active');
            $table->text('purpose')->nullable();
            $table->enum('condition_at_assignment', ['new', 'good', 'fair', 'poor', 'damaged']);
            $table->enum('condition_at_return', ['new', 'good', 'fair', 'poor', 'damaged'])->nullable();
            $table->timestamps();

            $table->index(['asset_id', 'status']);
            $table->index(['employee_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_assignments');
    }
};
