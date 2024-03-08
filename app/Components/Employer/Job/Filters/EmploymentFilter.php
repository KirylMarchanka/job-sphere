<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class EmploymentFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return $builder->when(
            !empty($this->data['employment']),
            fn(Builder $builder) => $builder->where('employment', $this->data['employment'])
        );
    }
}
