<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;

    }
    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:200|min:5',
            'content' => 'required|string|max:300|min:10',
        ];
    }
}
