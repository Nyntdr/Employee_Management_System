<?php

use App\Enums\AssetCondition;
use App\Enums\AssetConditions;
use App\Enums\AssignmentStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $assignmentStatuses = array_column(AssignmentStatus::cases(), 'value');
        $conditions = array_column(AssetConditions::cases(), 'value');

        Schema::create('asset_assignments', function (Blueprint $table) use ($assignmentStatuses, $conditions) {
            $table->id('assignment_id');
            
            // Foreign keys
            $table->foreignId('asset_id')
                  ->constrained('assets', 'asset_id')
                  ->onDelete('cascade');
                  
            $table->foreignId('employee_id')
                  ->constrained('employees', 'employee_id')
                  ->onDelete('restrict');
                  
            $table->foreignId('assigned_by')
                  ->constrained('users')
                  ->onDelete('restrict');
            
            // Dates
            $table->date('assigned_date');
            $table->date('returned_date')->nullable();
            
            // Status and purpose
            $table->enum('status', $assignmentStatuses)->default(AssignmentStatus::ACTIVE->value);
            $table->text('purpose')->nullable();
            
            // Condition tracking
            $table->enum('condition_at_assignment', $conditions);
            $table->enum('condition_at_return', $conditions)->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['asset_id', 'status']);
            $table->index(['employee_id', 'status']);
            $table->index('assigned_date');
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