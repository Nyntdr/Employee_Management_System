<?php

namespace App\Http\Requests;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Enums\JobTitle;
use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,employee_id',
            'contract_type' => 'required|in:'. implode(',', array_column(ContractType::cases(), 'value')),
            'job_title' => 'required|in:'. implode(',', array_column(JobTitle::cases(), 'value')),
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'probation_period' => 'required|numeric|min:0|max:365',
            'salary' => 'required|numeric|min:0',
            'contract_status' => 'required|in:'. implode(',', array_column(ContractStatus::cases(), 'value')),
        ];
    }
    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please select an employee',
            'contract_type.required' => 'Please select contract type',
            'job_title.required' => 'Please select job title',
            'start_date.required' => 'Start date is required',
            'salary.required' => 'Salary is required',
            'contract_status.required' => 'Please select contract status',
            'end_date.after' => 'End date must be after start date',
        ];
    }
}

