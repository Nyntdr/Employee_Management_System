<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_id' => 'required|exists:roles,role_id',
            'name' => 'required|string|max:20|regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9_]+$/|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:6',
                'max:12',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,12}$/'
            ],

            'first_name' => ['required', 'string', 'max:20', new AlphaSpaces],
            'last_name' => ['required', 'string', 'max:25', new AlphaSpaces],
            'gender' => 'required|in:male,female',
            'phone' => 'string|max:10|min:10',
            'secondary_phone' => 'nullable|string|max:10|min:10',
            'emergency_contact' => 'nullable|string|max:150',
            'department_id' => 'required|exists:departments,department_id',
            'dob' => 'required|date',
            'doj' => 'required|date',
        ];
    }
}
