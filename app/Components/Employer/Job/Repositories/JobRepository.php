<?php

namespace App\Components\Employer\Job\Repositories;

use App\Components\Employer\Job\DTO\PaginateFiltersDto;
use App\Components\Employer\Job\DTO\StoreJobDto;
use App\Components\Employer\Job\DTO\UpdateJobDto;
use App\Components\Employer\Job\Filters\JobFilterApplyer;
use App\Models\Employer;
use App\Models\EmployerJob;

class JobRepository
{
    private Employer $employer;
    private JobFilterApplyer $filterApplyer;

    public function __construct(JobFilterApplyer $filterApplyer)
    {
        $this->filterApplyer = $filterApplyer;
    }

    public function setEmployer(Employer $employer): self
    {
        $this->employer = $employer;
        return $this;
    }

    public function paginate(PaginateFiltersDto $filters, int $page = 1, int $perPage = 15): array
    {
        return $this->filterApplyer->apply(
            $this->employer->jobs()->with(['employer:id,name', 'city.country']),
            $filters->toArray()
        )->paginate(perPage: $perPage, page: $page)->toArray();
    }

    public function store(StoreJobDto $jobDto): EmployerJob
    {
        /** @var EmployerJob $job */
        $job = $this->employer->jobs()->create([
            'title' => $jobDto->title,
            'salary_from' => $jobDto->salaryFrom,
            'salary_to' => $jobDto->salaryTo,
            'salary_employer_paid_taxes' => $jobDto->employerPaidTaxes,
            'experience' => $jobDto->experience?->value,
            'education' => $jobDto->education?->value,
            'schedule' => $jobDto->schedule,
            'description' => $jobDto->description,
            'city_id' => $jobDto->cityId,
            'street' => $jobDto->street,
            'employment' => $jobDto->employment->value,
        ]);

        $job->skills()->attach($jobDto->skills);

        return $job;
    }

    public function update(int|EmployerJob $job, UpdateJobDto $jobDto): void
    {
        if (is_int($job)) {
            $job = $this->employer->jobs()->where('id', $job)->first();
        }

        $job->update([
            'title' => $jobDto->title,
            'salary_from' => $jobDto->salaryFrom,
            'salary_to' => $jobDto->salaryTo,
            'salary_employer_paid_taxes' => $jobDto->employerPaidTaxes,
            'experience' => $jobDto->experience?->value,
            'education' => $jobDto->education?->value,
            'schedule' => $jobDto->schedule,
            'description' => $jobDto->description,
            'city_id' => $jobDto->cityId,
            'street' => $jobDto->street,
            'employment' => $jobDto->employment->value,
        ]);

        $job->skills()->sync($jobDto->skills);
    }
}
