<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $primaryKey = 'attendance_id';
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'total_hours',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime:H:i',
        'clock_out' => 'datetime:H:i',
        'status' => AttendanceStatus::class,
    ];

    public function employee() : BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

}
