<?php

use App\Enums\JobTitle;
use App\Enums\LeaveStatus;
use App\Enums\ContractType;
use App\Enums\ContractStatus;
use App\Enums\AttendanceStatus;
use App\Enums\EmploymentStatus;
use App\Enums\PayStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
public function up(): void
{
    Schema::table('contracts', function (Blueprint $table) {
//        $table->string('job_title', 50)->default(JobTitle::INTERN->value)->change();
        $table->string('contract_type', 50)->default(ContractType::INTERN->value)->change();
        $table->string('contract_status', 50)->default(ContractStatus::ACTIVE->value)->change();
    });

    Schema::table('attendances', function (Blueprint $table) {
        $table->string('status', 50)->default(AttendanceStatus::PRESENT->value)->change();
    });

    Schema::table('employees', function (Blueprint $table) {
        $table->string('gender', 50)->nullable()->change();
        $table->string('employment_status', 50)->default(EmploymentStatus::ACTIVE->value)->change();
    });

    Schema::table('leaves', function (Blueprint $table) {
        $table->string('status', 50)->default(LeaveStatus::PENDING->value)->change();
    });

    Schema::table('payrolls', function (Blueprint $table) {
        $table->string('payment_status', 50)->default(PayStatus::PENDING->value)->change();
    });
}

public function down(): void
{
    Schema::table('contracts', function (Blueprint $table) {
        $jobs = array_column(JobTitle::cases(), 'value');
        $types = array_column(ContractType::cases(), 'value');
        $status = array_column(ContractStatus::cases(), 'value');

//        $table->enum('job_title', $jobs)->default(JobTitle::INTERN->value)->change();
        $table->enum('contract_type', $types)->default(ContractType::INTERN->value)->change();
        $table->enum('contract_status', $status)->default(ContractStatus::ACTIVE->value)->change();
    });

    Schema::table('attendances', function (Blueprint $table) {
        $attendance = array_column(AttendanceStatus::cases(), 'value');
        $table->enum('status', $attendance)->default(AttendanceStatus::PRESENT->value)->change();
    });

    Schema::table('employees', function (Blueprint $table) {
        $table->enum('gender', ['male', 'female'])->nullable()->change();
        $table->enum('employment_status', array_column(EmploymentStatus::cases(), 'value'))->default(EmploymentStatus::ACTIVE->value)->change();
    });

    Schema::table('leaves', function (Blueprint $table) {
        $leaveStatus = array_column(LeaveStatus::cases(), 'value');
        $table->enum('status', $leaveStatus)->default(LeaveStatus::PENDING->value)->change();
    });

    Schema::table('payrolls', function (Blueprint $table) {
        $payStatus = array_column(PayStatus::cases(), 'value');
        $table->enum('payment_status', $payStatus)->default(PayStatus::PENDING->value)->change();
    });
}
};
