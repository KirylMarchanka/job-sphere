<?php

namespace App\Http\Requests\Auth\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', Rule::exists('employers', 'email')],
            'password' => ['required', Password::default()],
        ];
    }
}
