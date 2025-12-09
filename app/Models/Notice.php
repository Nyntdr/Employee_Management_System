<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notice extends Model
{
    protected $primaryKey = 'notice_id';
    public $timestamps = true;
    
    protected $fillable = [
        'title',
        'content',
        'posted_by',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function poster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by','id');
    }
}