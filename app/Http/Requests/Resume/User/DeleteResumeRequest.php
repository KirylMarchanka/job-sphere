<?php

namespace App\Http\Requests\Resume\User;

use Illuminate\Foundation\Http\FormRequest;

class DeleteResumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->getKey() === $this->route()->parameter('resume')->getAttribute('user_id');
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
