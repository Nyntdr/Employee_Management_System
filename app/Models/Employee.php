<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'secondary_phone',
        'emergency_contact',
        'department_id',
        'position',
        'date_of_birth',
        'date_of_joining',
        'employment_status',
    ];
    
    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_joining' => 'date',
        'gender' => 'string',
        'employment_status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'employee_id', 'employee_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'employee_id');
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class, 'employee_id', 'employee_id');
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class, 'employee_id','employee_id');
    }

    public function assetAssignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class, 'employee_id','employee-id');
    }
}