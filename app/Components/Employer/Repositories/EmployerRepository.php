<?php

namespace App\Components\Employer\Repositories;

use App\Components\Employer\DTO\Employer as EmployerDto;
use App\Components\Employer\Filters\EmployerFilterApplyer;
use App\Models\Employer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmployerRepository
{
    private EmployerFilterApplyer $filterApplyer;

    public function __construct(EmployerFilterApplyer $filterApplyer)
    {
        $this->filterApplyer = $filterApplyer;
    }

    public function all(?string $name, ?int $sector): LengthAwarePaginator
    {
        $builder = Employer::query()->with(['sector.parent']);

        return $this->filterApplyer->apply($builder, ['name' => $name, 'sector' => $sector])->paginate();
    }

    public function show(int $employer, array $select = ['*']): array
    {
        return Employer::query()->select($select)->with(['sector.parent', 'jobs'])->whereKey($employer)->first()->toArray();
    }

    public function store(EmployerDto $employer): Employer
    {
        return Employer::query()->create($employer->toArray());
    }
}
