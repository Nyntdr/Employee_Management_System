<?php

namespace App\Http\Requests;

use App\Enums\AssetConditions;
use App\Enums\AssignmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,asset_id'],
            'employee_id' => ['required', 'exists:employees,employee_id'],
            'assigned_date' => ['required', 'date'],
            'returned_date' => ['nullable', 'date', 'after_or_equal:assigned_date'],
            'status' => ['required', Rule::enum(AssignmentStatus::class)],
            'purpose' => ['required', 'string', 'max:50'],
            'condition_at_assignment' => ['required', Rule::enum(AssetConditions::class)],
            'condition_at_return' => ['nullable', Rule::enum(AssetConditions::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Please select an asset',
            'employee_id.required' => 'Please select an employee',
            'assigned_date.required' => 'Assigned date is required',
            'returned_date.after_or_equal' => 'Return date cannot be before assigned date',
            'purpose.required' => 'Please provide the purpose of assignment',
            'condition_at_assignment.required' => 'Please select asset condition at assignment',
        ];
    }
}
