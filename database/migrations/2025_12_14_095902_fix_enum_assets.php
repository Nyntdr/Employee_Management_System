<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\AssetTypes;
use App\Enums\AssetStatuses;
use App\Enums\AssetConditions;
use App\Enums\AssignmentStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['type', 'status', 'current_condition']);
        });
        Schema::table('assets', function (Blueprint $table) {
            $table->string('type', 50)->default(AssetTypes::OTHER->value);
            $table->string('status', 50)->default(AssetStatuses::AVAILABLE->value);
            $table->string('current_condition', 50)->default(AssetConditions::NEW->value);
        });
        Schema::table('asset_assignments', function (Blueprint $table) {
            $table->dropColumn(['status', 'condition_at_assignment', 'condition_at_return']);
        });
        Schema::table('asset_assignments', function (Blueprint $table) {
            $table->string('status', 50)->default(AssignmentStatus::ACTIVE->value);
            $table->string('condition_at_assignment', 50);
            $table->string('condition_at_return', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['type', 'status', 'current_condition']);
        });
        Schema::table('assets', function (Blueprint $table) {
            $types = array_column(AssetTypes::cases(), 'value');
            $statuses = array_column(AssetStatuses::cases(), 'value');
            $conditions = array_column(AssetConditions::cases(), 'value');
            
            $table->enum('type', $types)->default(AssetTypes::OTHER->value);
            $table->enum('status', $statuses)->default(AssetStatuses::AVAILABLE->value);
            $table->enum('current_condition', $conditions)->default(AssetConditions::NEW->value);
        });
        Schema::table('asset_assignments', function (Blueprint $table) {
            $table->dropColumn(['status', 'condition_at_assignment', 'condition_at_return']);
        });
        
        Schema::table('asset_assignments', function (Blueprint $table) {
            $assignmentStatuses = array_column(AssignmentStatus::cases(), 'value');
            $conditions = array_column(AssetConditions::cases(), 'value');
            
            $table->enum('status', $assignmentStatuses)->default(AssignmentStatus::ACTIVE->value);
            $table->enum('condition_at_assignment', $conditions);
            $table->enum('condition_at_return', $conditions)->nullable();
        });
    }
};