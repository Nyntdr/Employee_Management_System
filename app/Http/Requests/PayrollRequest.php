<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PayStatus;
use Illuminate\Validation\Rule;

class PayrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $payrollId = $this->route('payroll') ?? $this->route('id');

        $rules = [
            'employee_id' => 'required|exists:employees,employee_id',
            'month_year' => [
                'required',
                'date_format:Y-m',
                Rule::unique('payrolls')
                    ->where('employee_id', $this->employee_id)
                    ->ignore($payrollId, 'payroll_id')
            ],
            'overtime_pay' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:' . implode(',', array_column(PayStatus::cases(), 'value')),
            'paid_date' => 'nullable|date',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please select an employee',
            'employee_id.exists' => 'Selected employee does not exist',
            'month_year.required' => 'Month and year are required',
            'month_year.date_format' => 'Month year must be in YYYY-MM format',
            'month_year.unique' => 'Payroll already exists for this employee and month',
            'payment_status.required' => 'Payment status is required',
            'payment_status.in' => 'Invalid payment status',
            'paid_date.required' => 'Paid date is required when status is Paid',
            'paid_date.date' => 'Paid date must be a valid date',
        ];
    }
}
