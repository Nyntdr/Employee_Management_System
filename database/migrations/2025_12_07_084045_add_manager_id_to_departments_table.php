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
        Schema::table('departments', function (Blueprint $table) {
            // $table->foreignId('manager_id')->constrained('employees','employee_id')->after('name')->nullable()->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('manager_id')->nullable()->after('name');
            $table->foreign('manager_id')->references('employee_id')  
                                                  ->on('employees')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn('manager_id');
        });
    }
};
