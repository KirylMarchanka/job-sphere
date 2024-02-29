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
        return $this->filterApplyer->apply(Employer::query(), ['name' => $name, 'sector' => $sector])->paginate();
    }

    public function store(EmployerDto $employer): Employer
    {
        return Employer::query()->create($employer->toArray());
    }
}
