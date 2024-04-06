<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class JobArchiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route()->parameter('job')->getAttribute('employer_id') === $this->user('web.employers')->getKey();
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
