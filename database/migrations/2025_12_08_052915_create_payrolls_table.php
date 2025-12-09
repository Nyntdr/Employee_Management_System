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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id('payroll_id');
            $table->foreignId('employee_id')->constrained('employees','employee_id')->onDelete('cascade')->onUpdate('cascade');
            $table->char('month_year',7);
            $table->decimal('basic_salary',10,2);
            $table->decimal('overtime_pay',10,2)->default(0.00);
            $table->decimal('bonus',10,2)->default(0.00);
            $table->decimal('deductions',10,2)->default(0.00);
            $table->decimal('net_salary',10,2);
            $table->enum('payment_status',['pending','paid','failed'])->default('pending');
            $table->date('paid_date')->nullable();
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->unique(['employee_id', 'month_year']);
            $table->index('month_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};