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
        Schema::table('contracts', function (Blueprint $table) {
            // $table->foreignId('employee_id')->constrained('employees','employee_id')->after('contract_id')->nullable()->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('employee_id')->nullable()->after('contract_id');
            $table->foreign('employee_id')->references('employee_id')  
                                                  ->on('employees')->onDelete('set null')->onUpdate('cascade')
                                                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropColumn('employee_id');
        });
    }
};
