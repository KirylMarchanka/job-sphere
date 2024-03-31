<?php

namespace App\Http\Requests\Job\Common;

use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'sector' => ['sometimes', 'nullable', Rule::exists('sectors', 'id')],
            'city' => ['sometimes', 'nullable', Rule::exists('cities', 'id')],
            'salary_from' => ['sometimes', 'nullable', 'integer', 'numeric'],
            'salary_to' => ['sometimes', 'nullable', 'integer', 'numeric'],
            'education' => ['sometimes', 'nullable', Rule::enum(JobEducationEnum::class)],
            'employment' => ['sometimes', 'nullable', Rule::enum(EmploymentEnum::class)],
            'experience' => ['sometimes', 'nullable', Rule::enum(JobExperienceEnum::class)],
            'schedule' => ['sometimes', 'nullable', Rule::enum(ScheduleEnum::class)],
            'skills' => ['sometimes', 'nullable', 'array', 'max:10'],
            'skills.*' => ['sometimes', 'integer', 'numeric', Rule::exists('skills', 'id')],
        ];
    }
}
