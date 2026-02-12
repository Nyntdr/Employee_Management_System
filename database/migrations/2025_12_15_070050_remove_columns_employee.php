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
            // Drop the columns
            $table->dropColumn(['position', 'employment_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Add the columns back if we need to rollback
            $table->string('position')->nullable()->after('department_id');
            $table->enum('employment_status', ['active', 'inactive', 'on_leave', 'terminated'])->default('active')->after('date_of_joining');
        });
    }
};