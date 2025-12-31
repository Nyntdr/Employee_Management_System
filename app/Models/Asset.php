<?php

namespace App\Models;

use App\Enums\AssetConditions;
use App\Enums\AssetStatuses;
use App\Enums\AssetTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $primaryKey = 'asset_id';
    protected $fillable = [
        'asset_code',
        'name',
        'type',
        'category',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'purchase_cost',
        'warranty_until',
        'status',
        'current_condition',
        'requested_by',
        'requested_at',
        'request_reason',
    ];

    protected $casts = [
        'type' => AssetTypes::class,
        'status' => AssetStatuses::class,
        'current_condition' => AssetConditions::class,
        'purchase_date' => 'date',
        'requested_at' => 'date',
        'warranty_until' => 'date',
        'purchase_cost' => 'decimal:2'
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class, 'asset_id', 'asset_id');
    }
    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'requested_by', 'employee_id');
    }
}
