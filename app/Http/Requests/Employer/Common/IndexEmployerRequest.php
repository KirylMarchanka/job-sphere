<?php

namespace App\Http\Requests\Employer\Common;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexEmployerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'sector' => ['nullable', 'integer', 'numeric', 'min:1', Rule::exists('sectors', 'id')]
        ];
    }
}
