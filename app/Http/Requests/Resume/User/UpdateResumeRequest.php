<?php

namespace App\Http\Requests\Resume\User;

use App\Components\Resume\Contacts\Enums\ResumeContactPreferredContactEnum;
use App\Components\Resume\Education\Enums\DegreeEnum;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Enums\StatusEnum;
use App\Components\Resume\Personal\Enums\SexEnum;
use App\Components\Resume\Specialization\Repositories\SpecializationRepository;
use App\Models\City;
use App\Models\EducationalInstitution;
use App\Models\Skill;
use App\Rules\EnsureThatAllFieldsArePresented;
use App\Rules\EnsureThatEntityLimitIsNotReached;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateResumeRequest extends FormRequest
{
    private array $specializations;
    private array $skills;
    private array $cities;
    private array $education;
    private array $educationIds;
    private array $workExperienceIds;

    public function authorize(): bool
    {
        return $this->user()->getKey() === $this->route()->parameter('resume')->getAttribute('user_id');
    }

    protected function prepareForValidation(): void
    {
        $this->specializations = (new SpecializationRepository())->getIds();
        $this->skills = Skill::query()->select(['id'])->get()->pluck('id')->toArray();
        $this->cities = City::query()->select(['id'])->get()->pluck('id')->toArray();
        $this->education = EducationalInstitution::query()->select(['id'])->get()->pluck('id')->toArray();
        $this->educationIds = $this->route()->parameter('resume')->load('education')->getRelation('education')->pluck('id')->toArray();
        $this->workExperienceIds = $this->route()->parameter('resume')->load('workExperience')->getRelation('workExperience')->pluck('id')->toArray();
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'integer', 'numeric', 'min:0', Rule::enum(StatusEnum::class)],
            'salary' => ['sometimes', 'nullable', 'integer', 'numeric', 'min:1'],
            'employment' => ['sometimes', 'integer', 'numeric', 'min:0', Rule::enum(EmploymentEnum::class)],
            'schedule' => ['sometimes', 'integer', 'numeric', 'min:0', Rule::enum(ScheduleEnum::class)],
            'description' => ['sometimes', 'nullable', 'string'],

            'specializations' => [
                'sometimes',
                'array',
                'between:1,5',
                new EnsureThatEntityLimitIsNotReached($this->route()->parameter('resume')),
            ],
            'specializations.*' => ['distinct', 'integer', 'numeric', 'min:1', Rule::in($this->specializations)],

            'skills' => [
                'sometimes',
                'array',
                'between:1,25',
                new EnsureThatEntityLimitIsNotReached($this->route()->parameter('resume')),
            ],
            'skills.*' => ['distinct', 'integer', 'numeric', 'min:1', Rule::in($this->skills)],

            'contact' => ['sometimes', 'array:mobile_number,comment,email,preferred_contact_source,other_sources'],
            'contact.mobile_number' => ['sometimes', 'string', 'size:12'],
            'contact.comment' => ['sometimes', 'nullable', 'string', 'max:255'],
            'contact.email' => ['sometimes', 'nullable', 'email', 'max:254'],
            'contact.preferred_contact_source' => [
                'sometimes',
                'integer',
                'numeric',
                'min:0',
                Rule::enum(ResumeContactPreferredContactEnum::class),
            ],
            'contact.other_sources' => ['sometimes', 'array:linkedin,telegram', 'max:2'],
            'contact.other_sources.linkedin' => ['sometimes', 'string', 'nullable'],
            'contact.other_sources.telegram' => ['sometimes', 'string', 'nullable'],

            'personal_information' => ['sometimes', 'array:name,surname,middle_name,birthdate,sex,city_id'],
            'personal_information.name' => ['sometimes', 'string', 'between:2,255'],
            'personal_information.surname' => ['sometimes', 'string', 'between:2,255'],
            'personal_information.middle_name' => ['sometimes', 'nullable', 'string', 'between:2,255'],
            'personal_information.birthdate' => ['sometimes', 'date_format:Y-m-d', 'before:-14 years'],
            'personal_information.sex' => ['sometimes', 'string', 'size:1', Rule::enum(SexEnum::class)],
            'personal_information.city_id' => ['sometimes', 'integer', 'numeric', 'min:1', Rule::in($this->cities)],

            'education' => [
                'sometimes',
                'array',
                'max:5',
                new EnsureThatEntityLimitIsNotReached($this->route()->parameter('resume')),
            ],
            'education.*' => [
                'sometimes',
                'array:id,educational_institution_id,department,specialization,degree,start_date,end_date',
                new EnsureThatAllFieldsArePresented([
                    'educational_institution_id',
                    'department',
                    'specialization',
                    'degree',
                    'start_date',
                    'end_date',
                ]),
            ],
            'education.*.id' => ['sometimes', 'integer', 'numeric', 'min:1', Rule::in($this->educationIds)],
            'education.*.educational_institution_id' => [
                'sometimes',
                'integer',
                'numeric',
                'min:1',
                Rule::in($this->education),
            ],
            'education.*.department' => ['sometimes', 'string', 'max:255'],
            'education.*.specialization' => ['sometimes', 'string', 'max:255'],
            'education.*.degree' => ['sometimes', 'integer', 'numeric', 'min:0', Rule::enum(DegreeEnum::class)],
            'education.*.start_date' => ['sometimes', 'date_format:Y-m', 'before_or_equal:today'],
            'education.*.end_date' => ['sometimes', 'date_format:Y-m', 'after_or_equal:education.*.start_date'],

            'work_experience' => [
                'sometimes',
                'array',
                'max:10',
                new EnsureThatEntityLimitIsNotReached($this->route()->parameter('resume')),
            ],
            'work_experience.*' => [
                'sometimes',
                'array:id,company_name,city_id,position,site_url,description,from,to',
                new EnsureThatAllFieldsArePresented([
                    'company_name',
                    'city_id',
                    'position',
                    'site_url',
                    'description',
                    'from',
                    'to',
                ])
            ],
            'work_experience.*.id' => ['sometimes', 'integer', 'numeric', 'min:1', Rule::in($this->workExperienceIds)],
            'work_experience.*.company_name' => ['sometimes', 'string', 'max:255'],
            'work_experience.*.city_id' => ['sometimes', 'integer', 'numeric', 'min:1', Rule::in($this->cities)],
            'work_experience.*.position' => ['sometimes', 'string', 'max:255'],
            'work_experience.*.site_url' => ['sometimes', 'nullable', 'string', 'max:255'],
            'work_experience.*.description' => ['sometimes', 'nullable', 'string'],
            'work_experience.*.from' => ['sometimes', 'date_format:Y-m', 'before_or_equal:today'],
            'work_experience.*.to' => ['sometimes', 'nullable', 'date_format:Y-m', 'before_or_equal:today'],
        ];
    }
}
