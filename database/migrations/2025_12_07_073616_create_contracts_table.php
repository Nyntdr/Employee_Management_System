<?php

use App\Enums\JobTitle;
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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id('contract_id');
            $table->enum('contract_type',['full_time','part_time','intern']);
            $table->string('job_title', 50)->default(JobTitle::INTERN->value);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('probation_period')->default(0);
            $table->string('working_hours',100)->nullable();
            $table->decimal('salary',10,2);
            $table->enum('contract_status', ['active', 'expired', 'terminated', 'renewed'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
