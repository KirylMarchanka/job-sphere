<?php

namespace App\Http\Requests\Employer\Common\Sectore;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexSectorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_id' => [
                'sometimes',
                'nullable',
                'integer',
                'numeric',
                'min:1',
                Rule::exists('sectors', 'id'),
            ],
        ];
    }
}
