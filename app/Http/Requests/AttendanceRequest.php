<?php

namespace App\Http\Requests;

use App\Enums\AttendanceStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'employee_id' => 'required|exists:employees,employee_id',
            'date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i',
        ];

        $rules['date'] = [
            'required',
            'date',
            'before_or_equal:today',
            Rule::unique('attendances')->where(function ($query) {
                return $query->where('employee_id', $this->employee_id);
            })->ignore($this->attendance?->attendance_id, 'attendance_id')
        ];

        if ($this->clock_in && $this->clock_out) {
            $rules['clock_out'] = 'date_format:H:i|after_or_equal:clock_in';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Please select an employee',
            'employee_id.exists' => 'Selected employee does not exist',
            'date.required' => 'Date is required',
            'date.unique' => 'Attendance already exists for this employee on this date',
            'clock_in.date_format' => 'Invalid time format (HH:MM)',
            'clock_out.date_format' => 'Invalid time format (HH:MM)',
            'clock_out.after_or_equal' => 'Clock out time must be after clock in time',
        ];
    }
}
