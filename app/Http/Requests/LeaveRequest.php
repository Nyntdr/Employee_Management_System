<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LeaveType;
use App\Models\Leave;
use Carbon\Carbon;

class LeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'leave_type_id' => [
                'required',
                'exists:leave_types,id',
                function ($attribute, $value, $fail) {
                    $leaveType = LeaveType::find($value);
                    if ($this->routeIs('leaves.*')) {
                        $employeeId = $this->employee_id;
                    } else {
                        $employeeId = auth()->user()->employee->employee_id;
                    }
                    if (!$employeeId) {
                        $fail('Employee ID is required.');
                        return;
                    }
                    $start = Carbon::parse($this->start_date);
                    $end = Carbon::parse($this->end_date);
                    $requestedDays = $start->diffInDays($end) + 1;
                    $usedDays = Leave::where('employee_id', $employeeId)
                        ->where('leave_type_id', $value)
                        ->whereYear('start_date', now()->year)
                        ->where('status', 'approved')
                        ->get()
                        ->sum(function ($leave) {
                            $leaveStart = Carbon::parse($leave->start_date);
                            $leaveEnd = Carbon::parse($leave->end_date);
                            return $leaveStart->diffInDays($leaveEnd) + 1;
                        });
                    if ($this->routeIs('leaves.update')) {
                        $leaveId = $this->route('leave') ?? $this->route('id');
                        $existingLeave = Leave::find($leaveId);

                        if ($existingLeave && $existingLeave->status === 'approved') {
                            $existingStart = Carbon::parse($existingLeave->start_date);
                            $existingEnd = Carbon::parse($existingLeave->end_date);
                            $existingDays = $existingStart->diffInDays($existingEnd) + 1;
                            $usedDays -= $existingDays;
                        }
                    }
                    if (($usedDays + $requestedDays) > $leaveType->max_days_per_year) {
                        $remaining = $leaveType->max_days_per_year - $usedDays;
                        $fail("You can only request $remaining more days for '{$leaveType->name}'.");
                    }
                }
            ],
            'employee_id' => 'sometimes|required|exists:employees,employee_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:20',
            'status' => 'sometimes|in:pending,approved,rejected,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'leave_type_id.required' => 'Please select a leave type.',
            'employee_id.required' => 'Please select an employee.',
            'start_date.required' => 'Start date is required.',
            'end_date.required' => 'End date is required.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'reason.required' => 'Please provide a reason for leave.',
            'reason.max' => 'Reason cannot exceed 20 characters. Try to summarize in 20 words if possible or email if it takes more.',
        ];
    }
}
