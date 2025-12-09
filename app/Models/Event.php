<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $primaryKey = 'event_id';
    public $timestamps = true;
    
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }
}