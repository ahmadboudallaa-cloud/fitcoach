<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCoachRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'specialty' => ['nullable', 'string', Rule::in($this->specialties())],
            'phone' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    private function specialties(): array
    {
        return [
            'Musculation',
            'Cardio',
            'Fitness',
            'Yoga',
            'Pilates',
            'Crossfit',
            'Nutrition',
            'Perte de poids',
            'Prise de masse',
            'Reeducation sportive',
        ];
    }
}