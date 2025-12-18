<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PayStatus;

class PayrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        $rules = [
            'employee_id' => 'required|exists:employees,employee_id',
            'month_year' => 'required|date_format:Y-m',
            'basic_salary' => 'required|numeric|min:0',
            'overtime_pay' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:' . implode(',', array_column(PayStatus::cases(), 'value')),
            'paid_date' => 'nullable|date',
        ];

        if ($this->input('payment_status') === PayStatus::PAID->value) {
            $rules['paid_date'] = 'required|date';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please select an employee',
            'employee_id.exists' => 'Selected employee does not exist',
            'month_year.required' => 'Month and year are required',
            'month_year.date_format' => 'Month year must be in YYYY-MM format',
            'basic_salary.required' => 'Basic salary is required',
            'basic_salary.numeric' => 'Basic salary must be a number',
            'basic_salary.min' => 'Basic salary cannot be negative',
            'payment_status.required' => 'Payment status is required',
            'payment_status.in' => 'Invalid payment status',
            'paid_date.required' => 'Paid date is required when status is Paid',
            'paid_date.date' => 'Paid date must be a valid date',
        ];
    }
}