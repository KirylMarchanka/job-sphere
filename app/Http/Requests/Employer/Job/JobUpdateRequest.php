<?php

namespace App\Http\Requests\Employer\Job;

use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route()->parameter('job')->getAttribute('employer_id') === $this->user('api.employers')->getKey();
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'salary_from' => 'sometimes|nullable|integer|numeric|min:1|lte:salary_to',
            'salary_to' => 'sometimes|nullable|integer|numeric|min:1|gte:salary_from',
            'salary_employer_paid_taxes' => 'sometimes|boolean',
            'experience' => ['sometimes', 'nullable', Rule::enum(JobExperienceEnum::class)],
            'education' => ['sometimes', 'nullable', Rule::enum(JobEducationEnum::class)],
            'schedule' => ['sometimes', Rule::enum(ScheduleEnum::class)],
            'description' => 'sometimes|string',
            'city_id' => ['sometimes', Rule::exists('cities', 'id')],
            'street' => 'sometimes|nullable|string|max:255',
            'employment' => ['sometimes', Rule::enum(EmploymentEnum::class)],
            'skills' => 'sometimes|array',
            'skills.*' => ['sometimes', 'distinct', 'integer', 'numeric', Rule::exists('skills', 'id')],
        ];
    }
}
