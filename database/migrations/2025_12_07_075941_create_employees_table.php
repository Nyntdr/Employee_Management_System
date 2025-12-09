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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('department_id')->constrained('departments','department_id')->onDelete('cascade')->onUpdate('cascade');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('phone', 20);
            $table->string('secondary_phone', 20)->nullable();
            $table->string('emergency_contact', 150)->nullable();
            $table->string('position', 100)->nullable();
            $table->date('date_of_birth');
            $table->date('date_of_joining');
            $table->enum('employment_status', ['active', 'terminated', 'on_leave'])->default('active');
            // $table->decimal('basic_salary', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
