<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SalaryFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return $builder->when(
            !empty($this->data['salary_from']),
            fn(Builder $builder) => $builder->where('salary_from', '>=', $this->data['salary_from'])
        )->when(
            !empty($this->data['salary_to']),
            fn(Builder $builder) => $builder->where('salary_to', '<=', $this->data['salary_to'])
        );
    }
}
