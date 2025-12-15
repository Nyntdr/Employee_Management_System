<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'employee_id' => 'required|exists:employees,employee_id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10|max:500',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['status'] = 'sometimes|string';
            $rules['approved_by'] = 'sometimes|nullable|exists:users,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please select an employee.',
            'employee_id.exists' => 'The selected employee does not exist.',
            'leave_type_id.required' => 'Please select a leave type.',
            'leave_type_id.exists' => 'The selected leave type does not exist.',
            'start_date.required' => 'Start date is required.',
            'start_date.after_or_equal' => 'Start date must be today or in the future.',
            'end_date.required' => 'End date is required.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'reason.required' => 'Please provide a reason for the leave.',
            'reason.min' => 'Reason must be at least 10 characters.',
            'reason.max' => 'Reason must not exceed 500 characters.',
        ];
    }
}