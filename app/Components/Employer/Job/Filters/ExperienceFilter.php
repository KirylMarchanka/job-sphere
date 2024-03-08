<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ExperienceFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return $builder->when(
            !empty($this->data['experience']),
            fn(Builder $builder) => $builder->where('experience', $this->data['experience'])
        );
    }
}
