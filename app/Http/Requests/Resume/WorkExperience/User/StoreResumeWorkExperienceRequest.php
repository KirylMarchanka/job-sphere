<?php

namespace App\Http\Requests\Resume\WorkExperience\User;

use App\Models\City;
use App\Rules\EnsureThatEntityLimitIsNotReached;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResumeWorkExperienceRequest extends FormRequest
{
    private array $cities;

    public function authorize(): bool
    {
        return $this->user()->getKey() === $this->route()->parameter('resume')->getAttribute('user_id');
    }

    protected function prepareForValidation(): void
    {
        $this->cities = City::query()->select(['id'])->get()->pluck('id')->toArray();
    }

    public function rules(): array
    {
        return [
            'work_experiences' => [
                'required',
                'array',
                'size:1',
                new EnsureThatEntityLimitIsNotReached($this->route()->parameter('resume')),
            ],
            'work_experiences.*' => [
                'required',
                'array:company_name,city_id,position,site_url,description,from,to',
            ],
            'work_experiences.*.company_name' => ['required', 'string', 'max:255'],
            'work_experiences.*.city_id' => ['required', 'integer', 'numeric', 'min:1', Rule::in($this->cities)],
            'work_experiences.*.position' => ['required', 'string', 'max:255'],
            'work_experiences.*.site_url' => ['present', 'nullable', 'string', 'max:255'],
            'work_experiences.*.description' => ['present', 'nullable', 'string'],
            'work_experiences.*.from' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'work_experiences.*.to' => ['present', 'nullable', 'date_format:Y-m-d', 'before_or_equal:today'],
        ];
    }
}
