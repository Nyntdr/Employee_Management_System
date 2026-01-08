<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:50|min:5',
            'description' => 'nullable|string',
            'event_date'  => 'required|date',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => 'Event title is required.',
            'event_date.required'=> 'Event date is required.',
            'end_time.after'     => 'End time must be after start time.',
            'start_time.required'=> 'Event start time is required.',
            'end_time.required'=> 'Event end time is required.',
        ];
    }
}
