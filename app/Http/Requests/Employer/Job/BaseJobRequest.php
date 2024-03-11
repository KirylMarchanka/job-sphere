<?php

namespace App\Http\Requests\Employer\Job;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class BaseJobRequest extends FormRequest
{
    abstract public function authorize(): bool;

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
