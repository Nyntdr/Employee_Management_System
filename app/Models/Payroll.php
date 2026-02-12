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
        'month_year' => 'date:Y-m',
        'basic_salary' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id','employee_id');
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by','id');
    }
    public function calculateNetSalary(): float
    {
        $totalEarnings = $this->basic_salary + ($this->overtime_pay ?? 0) + ($this->bonus ?? 0);
        $totalDeductions = $this->deductions ?? 0;
        
        return $totalEarnings - $totalDeductions;
    }
}