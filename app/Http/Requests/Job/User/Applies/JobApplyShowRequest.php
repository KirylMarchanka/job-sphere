<?php

namespace App\Http\Requests\Job\User\Applies;

use Illuminate\Foundation\Http\FormRequest;

class JobApplyShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('web.users')
            ->resumes()
            ->where('id', $this->route()->parameter('apply')->getAttribute('resume_id'))
            ->exists();
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
