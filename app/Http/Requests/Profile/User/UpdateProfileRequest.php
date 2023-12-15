<?php

namespace App\Http\Requests\Profile\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignoreModel(Auth::user())],
            'mobile_number' => [
                'present',
                'nullable',
                'string',
                'max:30',
                Rule::unique('users', 'mobile_number')->ignoreModel(Auth::user())
            ],
            'old_password' => 'sometimes|current_password:api',
            'password' => ['required_with:old_password', 'confirmed', Password::default()],
        ];
    }

    protected function passedValidation(): void
    {
        if ($this->filled('password')) {
            $this->merge(['password' => Hash::make($this->input('password'))]);
        }
    }
}
