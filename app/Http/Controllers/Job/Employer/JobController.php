<?php

namespace App\Http\Controllers\Job\Employer;

use App\Components\City\Repositories\CityRepository;
use App\Components\Employer\Job\DTO\PaginateFiltersDto;
use App\Components\Employer\Job\DTO\StoreJobDto;
use App\Components\Employer\Job\DTO\UpdateJobDto;
use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Employer\Job\Repositories\JobRepository;
use App\Components\Employer\Sector\Repositories\SectorRepository;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Skill\Repositories\SkillRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Job\Common\JobIndexRequest;
use App\Http\Requests\Job\JobEditRequest;
use App\Http\Requests\Job\JobStoreRequest;
use App\Http\Requests\Job\JobUpdateRequest;
use App\Models\EmployerJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(
        JobIndexRequest  $request,
        JobRepository    $jobRepository,
        SectorRepository $sectorRepository,
        CityRepository   $cityRepository,
        SkillRepository  $skillRepository,
    ): View
    {
        $jobs = $jobRepository->setEmployer($request->user('web.employers'))->paginate(
            new PaginateFiltersDto(
                title: $request->input('title'),
                sector: $request->input('sector'),
                city: $request->input('city'),
                salaryFrom: $request->input('salary_from'),
                salaryTo: $request->input('salary_to'),
                education: $request->whenFilled('education', fn(int $education) => JobEducationEnum::from($education), fn() => null),
                employment: $request->whenFilled('employment', fn(int $employment) => EmploymentEnum::from($employment), fn() => null),
                experience: $request->whenFilled('experience', fn(int $experience) => JobExperienceEnum::from($experience), fn() => null),
                schedule: $request->whenFilled('schedule', fn(int $schedule) => ScheduleEnum::from($schedule), fn() => null),
                skills: $request->input('skills'),
            ),
            $request->integer('page', 1),
            $request->integer('per_page', 10)
        );

        return view('employers.jobs.employer-index', [
            'jobs' => $jobs,
            'sectors' => $sectorRepository->all(),
            'cities' => $cityRepository->all(),
            'education' => JobEducationEnum::toArray(),
            'employment' => EmploymentEnum::toArray(),
            'experience' => JobExperienceEnum::toArray(),
            'schedule' => ScheduleEnum::toArray(),
            'skills' => $skillRepository->all(),
            'data' => $request->toArray(),
        ]);
    }

    public function create(SkillRepository $skillRepository, CityRepository $cityRepository): View
    {
        return view('employers.jobs.create', [
            'experience' => JobExperienceEnum::toArray(),
            'education' => JobEducationEnum::toArray(),
            'schedule' => ScheduleEnum::toArray(),
            'employment' => EmploymentEnum::toArray(),
            'skills' => $skillRepository->all(),
            'cities' => $cityRepository->all(),
        ]);
    }

    public function store(JobStoreRequest $request, JobRepository $repository): RedirectResponse
    {
        $job = $repository->setEmployer($request->user('web.employers'))->store(new StoreJobDto(
            $request->input('title'),
            $request->input('salary_from'),
            $request->input('salary_to'),
            $request->boolean('salary_employer_paid_taxes'),
            JobExperienceEnum::from($request->integer('experience')),
            JobEducationEnum::from($request->integer('education')),
            ScheduleEnum::from($request->integer('schedule')),
            $request->input('description'),
            $request->integer('city_id'),
            $request->input('street'),
            EmploymentEnum::from($request->integer('employment')),
            $request->input('skills')
        ));

        return redirect()->route('employers.jobs.show', ['employer' => $request->user('web.employers'), 'job' => $job->getKey()]);
    }

    public function edit(JobEditRequest $request, EmployerJob $job, SkillRepository $skillRepository, CityRepository $cityRepository): View
    {
        $job->load('skills');

        return view('employers.jobs.edit', [
            'job' => $job,
            'experience' => JobExperienceEnum::toArray(),
            'education' => JobEducationEnum::toArray(),
            'schedule' => ScheduleEnum::toArray(),
            'employment' => EmploymentEnum::toArray(),
            'skills' => $skillRepository->all(),
            'cities' => $cityRepository->all(),
        ]);
    }

    public function update(JobUpdateRequest $request, EmployerJob $job, JobRepository $repository): RedirectResponse
    {
        $repository->setEmployer($request->user('web.employers'))->update($job, new UpdateJobDto(
            $request->input('title', $job->getAttribute('title')),
            $request->whenHas('salary_from', fn(?int $salary) => $salary, fn() => $job->getAttribute('salary_from')),
            $request->whenHas('salary_to', fn(?int $salary) => $salary, fn() => $job->getAttribute('salary_to')),
            $request->whenHas('salary_employer_paid_taxes', fn(?bool $paidTaxes) => $paidTaxes, fn() => $job->getAttribute('salary_employer_paid_taxes')),
            $request->whenHas('experience', function (?int $paidTaxes) {
                if (null === $paidTaxes) {
                    return null;
                }

                return JobExperienceEnum::from($paidTaxes);
            }, fn() => JobExperienceEnum::from($job->getRawOriginal('experience'))),
            $request->whenHas('education', function (?int $education) {
                if (null === $education) {
                    return null;
                }

                return JobEducationEnum::from($education);
            }, fn() => JobEducationEnum::from($job->getRawOriginal('education'))),
            $request->whenHas('schedule', fn(int $schedule) => ScheduleEnum::from($schedule), fn() => ScheduleEnum::from($job->getRawOriginal('schedule'))),
            $request->whenHas('description', fn(string $description) => $description, fn() => $job->getRawOriginal('description')),
            $request->whenHas('city_id', fn(int $cityId) => $cityId, fn() => $job->getAttribute('city_id')),
            $request->whenHas('street', fn(?string $street) => $street, fn() => $job->getAttribute('street')),
            $request->whenHas('employment', fn(int $employment) => EmploymentEnum::from($employment), fn() => EmploymentEnum::from($job->getRawOriginal('employment'))),
            $request->whenHas('skills', fn(array $skills) => $skills, fn() => $job->load('skills')->getRelation('skills')->pluck('skill_id')->toArray()),
        ));

        return redirect()->route('employers.jobs.show', ['employer' => $request->user('web.employers'), 'job' => $job->getKey()]);
    }
}
