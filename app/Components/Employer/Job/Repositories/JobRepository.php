<?php

namespace App\Components\Employer\Job\Repositories;

use App\Components\Employer\Job\DTO\PaginateFiltersDto;
use App\Components\Employer\Job\DTO\StoreJobDto;
use App\Components\Employer\Job\DTO\UpdateJobDto;
use App\Components\Employer\Job\Filters\JobFilterApplyer;
use App\Models\Employer;
use App\Models\EmployerJob;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function paginate(PaginateFiltersDto $filters, int $page = 1, int $perPage = 15): LengthAwarePaginator
    {
        $jobs = EmployerJob::query()->select([
            'id',
            'employer_id',
            'title',
            'salary_from',
            'salary_to',
            'salary_employer_paid_taxes',
            'experience',
            'city_id',
            'employment',
            'schedule',
            'description',
        ])->with(['employer:id,name', 'city.country', 'skills']);

        return $this->filterApplyer->apply($jobs, $filters->toArray())->paginate(perPage: $perPage, page: $page);
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

    public function getPreviewJobs(): array
    {
        return EmployerJob::query()->with(['employer', 'city.country'])
            ->with('skills', fn(BelongsToMany $builder) => $builder->limit(5))
            ->where('is_archived', false)
            ->inRandomOrder()
            ->limit(5)
            ->get()
            ->toArray();
    }
}
