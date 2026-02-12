<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        $rules = [
            'max_days_per_year' => 'required|numeric|between:1,365',
        ];
        if ($method === 'POST') {
            $rules['name'] = [
                'required',
                'unique:leave_types,name',
                new AlphaSpaces,
            ];
        }
        if ($method === 'PUT') {
            $leaveTypeId = $this->route('leave_type') ?? $this->route('id');
            $rules['name'] = ['required','string', new AlphaSpaces, Rule::unique('leave_types', 'name')->ignore($leaveTypeId),];
        }
        return $rules;
    }
}
