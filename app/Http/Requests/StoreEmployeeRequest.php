<?php

namespace App\Http\Requests;

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
    'role_id'        => 'required|exists:roles,role_id',
    'name'           => 'required|string|max:255',
    'email'          => 'required|email|unique:users,email',
    'password'       => 'required|min:6|confirmed',

    'first_name'     => 'required|string|max:100',
    'last_name'      => 'required|string|max:100',
    'gender'         => 'required|in:male,female',
    'phone'          => 'string|max:20',
    'secondary_phone'=> 'nullable|string|max:20',
    'emergency_contact' =>'string|max:150',
    'department_id'  => 'required|exists:departments,department_id',
    'position'       => 'nullable|string|max:100',
    'dob'            => 'nullable|date',
    'doj'            => 'required|date',                   
    'status'         => 'required|in:active,terminated,on_leave',
];
    }
}