<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetAssignment extends Model
{
    protected $primaryKey = 'assignment_id';
    public $timestamps = true;
    
    protected $fillable = [
        'asset_id',
        'employee_id',
        'assigned_by',
        'assigned_date',
        'returned_date',
        'status',
        'purpose',
        'condition_at_assignment',
        'condition_at_return'
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'returned_date' => 'date'
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id','asset_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id','employee_id');
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by','id');
    }
}