<?php

namespace App\Http\Requests\Employer\Job\Employer\Invites;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobInviteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('api.employers')->getKey() === $this->route()->parameter('job')->getAttribute('employer_id');
    }

    public function rules(): array
    {
        return [
            'resume' => [
                'required',
                'integer',
                'numeric',
                Rule::exists('resumes', 'id'),
                Rule::unique('job_applies', 'resume_id')
                    ->where('employer_job_id', $this->route()->parameter('job')->getKey()),
            ],
            'message' => 'required|string|max:1500',
        ];
    }
}
