<?php

namespace App\Http\Requests;

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
            'name'    => 'required|string|max:255',
            'email'   => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => 'nullable|min:6|confirmed', 

            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'gender'          => 'required|in:male,female', 
            'phone'           => 'required|string|max:20', 
            'secondary_phone' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:150', 
            'department_id'   => 'required|exists:departments,department_id', 
            'position'        => 'nullable|string|max:100',
            'dob'             => 'nullable|date|before:today',
            'doj'             => 'required|date',
            'status'          => 'required|in:active,terminated,on_leave',
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