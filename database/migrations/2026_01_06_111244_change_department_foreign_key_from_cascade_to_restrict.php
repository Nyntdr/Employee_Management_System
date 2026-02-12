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
        Schema::table('employees', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['department_id']);

            // Re-add the foreign key with RESTRICT instead of CASCADE
            $table->foreign('department_id')
                ->references('department_id')
                ->on('departments')
                ->onUpdate('cascade')  // Keep cascade for updates
                ->onDelete('restrict'); // Changed from cascade to restrict
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Drop the restrict foreign key
            $table->dropForeign(['department_id']);

            // Re-add the original cascade foreign key
            $table->foreign('department_id')
                ->references('department_id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // Original setting
        });
    }
};
