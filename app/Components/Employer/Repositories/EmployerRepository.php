<?php

namespace App\Components\Employer\Repositories;

use App\Components\Employer\DTO\Employer as EmployerDto;
use App\Components\Employer\Filters\EmployerFilterApplyer;
use App\Models\Employer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class EmployerRepository
{
    private EmployerFilterApplyer $filterApplyer;

    public function __construct(EmployerFilterApplyer $filterApplyer)
    {
        $this->filterApplyer = $filterApplyer;
    }

    public function all(?string $name = null, ?int $sector = null, ?int $perPage = null): LengthAwarePaginator
    {
        $builder = Employer::query()->with(['sector.parent'])->withCount('jobs');

        return $this->filterApplyer->apply($builder, ['name' => $name, 'sector' => $sector])->paginate(perPage: $perPage);
    }

    public function getPreviewEmployers(): array
    {
        return Employer::query()->with(['sector.parent'])->withCount('jobs')->whereHas('jobs', function (Builder $builder) {
            return $builder->where('is_archived', false);
        })->limit(5)->get()->toArray();
    }

    public function show(int $employer, array $select = ['*']): array
    {
        return Employer::query()->select($select)->with(['sector.parent', 'jobs'])->whereKey($employer)->first()->toArray();
    }

    public function store(EmployerDto $employer): Employer
    {
        return Employer::query()->create($employer->toArray());
    }

    public function find(int $key): ?Employer
    {
        return Employer::query()->whereKey($key)->first();
    }
}
