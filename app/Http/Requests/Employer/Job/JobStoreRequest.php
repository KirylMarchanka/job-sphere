<?php

namespace App\Http\Requests\Employer\Job;

use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'salary_from' => 'present|nullable|integer|numeric|min:1|lte:salary_to',
            'salary_to' => 'present|nullable|integer|numeric|min:1|gte:salary_from',
            'salary_employer_paid_taxes' => 'required|boolean',
            'experience' => ['present', 'nullable', Rule::enum(JobExperienceEnum::class)],
            'education' => ['present', 'nullable', Rule::enum(JobEducationEnum::class)],
            'schedule' => ['required', Rule::enum(ScheduleEnum::class)],
            'description' => 'required|string',
            'city_id' => ['required', Rule::exists('cities', 'id')],
            'street' => 'present|nullable|string|max:255',
            'employment' => ['required', Rule::enum(EmploymentEnum::class)],
            'skills' => 'required|array',
            'skills.*' => ['required', 'distinct', 'integer', 'numeric', Rule::exists('skills', 'id')],
        ];
    }
}
