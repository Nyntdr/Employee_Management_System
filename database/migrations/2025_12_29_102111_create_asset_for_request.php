<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            $table->foreignId('requested_by')->nullable()->after('current_condition')
                ->constrained('employees','employee_id')
                ->nullOnDelete();
            $table->timestamp('requested_at')
                ->nullable()
                ->after('requested_by');
            $table->text('request_reason')
                ->nullable()
                ->after('requested_at');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('request_reason');
            $table->dropColumn('requested_at');

            $table->dropForeign(['requested_by']);
            $table->dropColumn('requested_by');
        });
    }
};
