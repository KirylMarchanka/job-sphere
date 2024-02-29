<?php

namespace App\Http\Requests\Auth\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'name' => ['required', 'string', 'max:255'],
            'sector_id' => ['required', 'integer', 'numeric', 'min:1', Rule::exists('sectors', 'id')],
            'email' => ['required', 'email', Rule::unique('employers', 'email')],
            'description' => ['required', 'string'],
            'site_url' => ['sometimes', 'nullable', 'url', 'max:255'],
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }
}
