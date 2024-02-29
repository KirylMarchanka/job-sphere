<?php

namespace App\Components\Employer\Repositories;

use App\Components\Employer\DTO\Employer;
use App\Models\Employer as EmployerModel;

class EmployerRepository
{
    public function store(Employer $employer): EmployerModel
    {
        return EmployerModel::query()->create($employer->toArray());
    }
}
