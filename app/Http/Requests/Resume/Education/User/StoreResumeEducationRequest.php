<?php

namespace App\Http\Requests\Resume\Education\User;

use App\Components\Resume\Education\Enums\DegreeEnum;
use App\Models\EducationalInstitution;
use App\Rules\EnsureThatEntityLimitIsNotReached;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResumeEducationRequest extends FormRequest
{
    private array $education;

    protected function prepareForValidation(): void
    {
        $this->education = EducationalInstitution::query()->select(['id'])->get()->pluck('id')->toArray();
    }

    public function authorize(): bool
    {
        return $this->user()->getKey() === $this->route()->parameter('resume')->getAttribute('user_id');
    }

    public function rules(): array
    {
        return [
            'education' => [
                'required',
                'array',
                'size:1',
                new EnsureThatEntityLimitIsNotReached($this->route()->parameter('resume')),
            ],
            'education.*' => [
                'required',
                'array:educational_institution_id,department,specialization,degree,start_date,end_date',
            ],
            'education.*.educational_institution_id' => [
                'required',
                'integer',
                'numeric',
                'min:1',
                Rule::in($this->education),
            ],
            'education.*.department' => ['required', 'string', 'max:255'],
            'education.*.specialization' => ['required', 'string', 'max:255'],
            'education.*.degree' => ['required', 'integer', 'numeric', Rule::enum(DegreeEnum::class)],
            'education.*.start_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'education.*.end_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:education.*.start_date'],
        ];
    }
}
