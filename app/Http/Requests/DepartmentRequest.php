<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $department = $this->route('department');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                new AlphaSpaces,
                Rule::unique('departments', 'name')
                    ->ignore(
                        $department?->department_id ?? $department,
                        'department_id'),
            ],
            'manager_id' => 'nullable|integer|exists:employees,employee_id',
        ];
    }
}
