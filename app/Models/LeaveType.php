<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class LeaveType extends Model
{

    protected $fillable = [
        'name',
        'max_days_per_year',
    ];

    protected $casts = [
        'max_days_per_year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class, 'leave_type_id', 'id');
    }
}
