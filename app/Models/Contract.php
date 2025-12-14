<?php

namespace App\Models;

use App\Enums\JobTitle;
use App\Models\Employee;
use App\Enums\ContractType;
use App\Enums\ContractStatus;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $primaryKey = 'contract_id';
    protected $fillable=[
        'employee_id',
        'contract_type',
        'job_title',
        'start_date',
        'end_date',
        'probation_period',
        'working_hours',
        'salary',
        'contract_status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
        protected $casts = [
            'start_date'=>'date',
            'end_date'=>'date',
       'contract_type' => ContractType::class,
        'contract_status' => ContractStatus::class,
        'job_title' => JobTitle::class,
    ];

}

