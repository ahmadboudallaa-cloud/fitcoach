<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'exercise_name' => ['nullable', 'string', 'max:255'],
            'sets' => ['nullable', 'integer', 'min:1'],
            'reps' => ['nullable', 'integer', 'min:1'],
            'exercise_notes' => ['nullable', 'string'],
        ];
    }
}
