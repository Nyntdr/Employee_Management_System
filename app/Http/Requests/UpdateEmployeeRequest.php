<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employee = $this->route('employee');
        $userId = $employee?->user?->id;

        return [
            'role_id' => 'required|exists:roles,role_id',
            'name'    => 'required|string|max:20',
            'email'   => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => 'nullable|min:6|confirmed',

            'first_name'      => ['required', 'string', 'max:20',new AlphaSpaces],
            'last_name'       => ['required', 'string', 'max:20',new AlphaSpaces],
            'gender'          => 'required|in:male,female',
            'phone'           => 'required|string|max:10',
            'secondary_phone' => 'nullable|string|max:10',
            'emergency_contact' => 'nullable|string|max:150',
            'department_id'   => 'required|exists:departments,department_id',
            'dob'             => 'required|date|before:today',
            'doj'             => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already taken by another user.',
            'department_id.exists' => 'The selected department is invalid.',
            'dob.before' => 'Date of birth must be in the past.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 6 characters.',
        ];
    }
}
