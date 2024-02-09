<?php

namespace App\Http\Requests\Resume\User;

use App\Components\Resume\Contacts\Enums\ResumeContactPreferredContactEnum;
use App\Components\Resume\DTOs\ResumeContactOtherSourceDto;
use App\Components\Resume\Education\Enums\DegreeEnum;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Enums\StatusEnum;
use App\Components\Resume\Personal\Enums\SexEnum;
use App\Components\Resume\Specialization\Repositories\SpecializationRepository;
use App\Models\City;
use App\Models\EducationalInstitution;
use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResumeRequest extends FormRequest
{
    private array $specializations;
    private array $skills;
    private array $cities;
    private array $education;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->specializations = (new SpecializationRepository())->getIds();
        $this->skills = Skill::query()->select(['id'])->get()->pluck('id')->toArray();
        $this->cities = City::query()->select(['id'])->get()->pluck('id')->toArray();
        $this->education = EducationalInstitution::query()->select(['id'])->get()->pluck('id')->toArray();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'integer', 'numeric', 'min:0', Rule::enum(StatusEnum::class)],
            'salary' => ['present', 'nullable', 'integer', 'numeric', 'min:1'],
            'employment' => ['required', 'integer', 'numeric', 'min:0', Rule::enum(EmploymentEnum::class)],
            'schedule' => ['required', 'integer', 'numeric', 'min:0', Rule::enum(ScheduleEnum::class)],
            'description' => ['present', 'nullable', 'string'],

            'specializations' => ['sometimes', 'array', 'between:1,5'],
            'specializations.*' => ['distinct', 'integer', 'numeric', 'min:1', Rule::in($this->specializations)],

            'skills' => ['sometimes', 'array', 'between:1,25'],
            'skills.*' => ['distinct', 'integer', 'numeric', 'min:1', Rule::in($this->skills)],

            'contact' => ['required', 'array:mobile_number,comment,email,preferred_contact_source,other_sources'],
            'contact.mobile_number' => ['required', 'string', 'size:12'],
            'contact.comment' => ['present', 'nullable', 'string', 'max:255'],
            'contact.email' => ['present', 'nullable', 'email', 'max:254'],
            'contact.preferred_contact_source' => ['required', 'integer', 'numeric', 'min:0', Rule::enum(ResumeContactPreferredContactEnum::class)],
            'contact.other_sources' => ['sometimes', 'array:linkedin,telegram', 'max:2'],
            'contact.other_sources.linkedin' => ['string'],
            'contact.other_sources.telegram' => ['string'],

            'personal_information' => ['required', 'array:name,surname,middle_name,birthdate,sex,city_id'],
            'personal_information.name' => ['required', 'string', 'between:2,255'],
            'personal_information.surname' => ['required', 'string', 'between:2,255'],
            'personal_information.middle_name' => ['present', 'nullable', 'string', 'between:2,255'],
            'personal_information.birthdate' => ['required', 'date_format:Y-m-d', 'before:-14 years'],
            'personal_information.sex' => ['required', 'string', 'size:1', Rule::enum(SexEnum::class)],
            'personal_information.city_id' => ['required', 'integer', 'numeric', 'min:1', Rule::in($this->cities)],

            'education' => ['required', 'array', 'max:5'],
            'education.*' => ['required', 'array:educational_institution_id,department,specialization,degree,start_date,end_date'],
            'education.*.educational_institution_id' => ['required', 'integer', 'numeric', 'min:1', Rule::in($this->education)],
            'education.*.department' => ['required', 'string', 'max:255'],
            'education.*.specialization' => ['required', 'string', 'max:255'],
            'education.*.degree' => ['required', 'integer', 'numeric', 'min:0', Rule::enum(DegreeEnum::class)],
            'education.*.start_date' => ['required', 'date_format:Y-m', 'before_or_equal:today'],
            'education.*.end_date' => ['required', 'date_format:Y-m', 'after_or_equal:education.*.start_date'],

            'work_experience' => ['sometimes', 'array', 'max:10'],
            'work_experience.*' => ['required_with:work_experience', 'array:company_name,city_id,position,site_url,description,from,to'],
            'work_experience.*.company_name' => ['required_with:work_experience.*', 'string', 'max:255'],
            'work_experience.*.city_id' => ['required_with:work_experience.*', 'integer', 'numeric', 'min:1', Rule::in($this->cities)],
            'work_experience.*.position' => ['required_with:work_experience.*', 'string', 'max:255'],
            'work_experience.*.site_url' => ['sometimes', 'nullable', 'string', 'max:255'],
            'work_experience.*.description' => ['sometimes', 'nullable', 'string'],
            'work_experience.*.from' => ['required_with:work_experience.*', 'date_format:Y-m', 'before_or_equal:today'],
            'work_experience.*.to' => ['sometimes', 'nullable', 'date_format:Y-m', 'before_or_equal:today'],
        ];
    }

    protected function passedValidation(): void
    {
        $contact = $this->input('contact');
        $contact['mobileNumber'] = $contact['mobile_number'];
        $contact['preferredContactSource'] = ResumeContactPreferredContactEnum::from($contact['preferred_contact_source']);
        $contact['otherSources'] = new ResumeContactOtherSourceDto($contact['other_sources']['linkedin'], $contact['other_sources']['telegram']);
        unset($contact['preferred_contact_source'], $contact['other_sources'], $contact['mobile_number']);
        $this->offsetSet('contact', $contact);

        $personalInformation = $this->input('personal_information');
        $personalInformation['sex'] = SexEnum::from($personalInformation['sex']);
        $personalInformation['birthdate'] = Carbon::parse($personalInformation['birthdate']);
        $personalInformation['middleName'] = $personalInformation['middle_name'];
        $personalInformation['cityId'] = $personalInformation['city_id'];
        unset($personalInformation['middle_name'], $personalInformation['city_id']);
        $this->offsetSet('personal_information', $personalInformation);

        $this->offsetSet('education', array_map(function (array $education) {
            $education['degree'] = DegreeEnum::from($education['degree']);
            $education['startDate'] = Carbon::parse($education['start_date']);
            $education['endDate'] = Carbon::parse($education['end_date']);
            $education['educationalInstitutionId'] = $education['educational_institution_id'];

            unset($education['educational_institution_id'], $education['start_date'], $education['end_date']);

            return $education;
        }, $this->input('education')));

        if ($this->isNotFilled('work_experience')) {
            return;
        }

        $this->offsetSet('work_experience', array_map(function (array $workExperience) {
            $workExperience['from'] = Carbon::parse($workExperience['from']);
            $workExperience['to'] = isset($workExperience['to']) ? Carbon::parse($workExperience['to']) : null;
            $workExperience['companyName'] = $workExperience['company_name'];
            $workExperience['cityId'] = $workExperience['city_id'];
            $workExperience['siteUrl'] = $workExperience['site_url'];

            unset($workExperience['company_name'], $workExperience['city_id'], $workExperience['site_url']);

            return $workExperience;
        }, $this->input('work_experience')));
    }
}
