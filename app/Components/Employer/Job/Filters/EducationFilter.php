<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class EducationFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return $builder->when(
            !empty($this->data['education']),
            fn(Builder $builder) => $builder->where('education', $this->data['education'])
        );
    }
}
