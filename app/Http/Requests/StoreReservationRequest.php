<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'availability_id' => [
                'required',
                Rule::exists('coach_availabilities', 'id')->where('is_available', true),
            ],
            'notes' => ['nullable', 'string'],
        ];
    }
}
