<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'This username is already taken.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}