<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $primaryKey = 'attendance_id';
    public $timestamps = true;
    protected $fillable=[
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'total_hours',
        'status',
    ];

  protected $casts = [
        'status' => AttendanceStatus::class,
        'date'=>'date',
        'total_hours'=>'datetime:H:i',
        'clock_in'=> 'datetime:H:i',
        'clock_out'=>'datetime:H:i',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function calculateTotalHours(){
        if ($this->clock_in && $this->clock_out) {
            return $this->clock_out->diff($this->clock_in)->format('%H:%I:%S');
        }
        return null;
    }
}
