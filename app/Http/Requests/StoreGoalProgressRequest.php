<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGoalProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'goal' => ['required', 'string', 'max:255'],
            'progress' => ['required', 'integer', 'min:0', 'max:100'],
            'progress_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
