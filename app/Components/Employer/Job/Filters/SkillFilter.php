<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SkillFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return $builder->when(
            !empty($this->data['skills']),
            fn(Builder $builder) => $builder->whereHas('skills', function (Builder $builder) {
                return $builder->whereIn('id', $this->data['skills']);
            })
        );
    }
}
