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
    'role_id'        => 'required|exists:roles,role_id',
    'name'           => 'required|string|max:20',
    'email'          => 'required|email|unique:users,email',
    'password'       => 'required|min:6|confirmed',

    'first_name'     =>  ['required', 'string', 'max:20',new AlphaSpaces],
    'last_name'      =>  ['required', 'string', 'max:25',new AlphaSpaces],
    'gender'         => 'required|in:male,female',
    'phone'          => 'string|max:10',
    'secondary_phone'=> 'nullable|string|max:10',
    'emergency_contact' =>'string|max:150',
    'department_id'  => 'required|exists:departments,department_id',
    'dob'            => 'required|date',
    'doj'            => 'required|date',
];
    }
}
