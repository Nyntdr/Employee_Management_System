<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $primaryKey='asset_id';
    protected $fillable=[
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
        'current_condition'
    ];

      protected $casts = [
        'purchase_date' => 'date',
        'warranty_until' => 'date',
        'purchase_cost' => 'decimal:2'
    ];
    
     public function assignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class, 'asset_id','asset_id');
    }
}
