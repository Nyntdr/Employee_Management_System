<?php

namespace App\Models;

use App\Enums\PayStatus;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $primaryKey='payroll_id';

    protected $fillable=[
        'employee_id',
        'month_year',
        'basic_salary',
        'overtime_pay',
        'bonus',
        'deductions',
        'net_salary',
        'payment_status',
        'paid_date',
        'generated_by'
    ];
    protected $casts = [
        'payment_status' => PayStatus::class,
        'paid_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id','employee_id');
    }

        public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by','id');
    }

}