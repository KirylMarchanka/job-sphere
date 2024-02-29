<?php

namespace App\Http\Requests\Employer\Common;

use Illuminate\Foundation\Http\FormRequest;

class IndexEmployerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
