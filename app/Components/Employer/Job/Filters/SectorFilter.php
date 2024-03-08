<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SectorFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return empty($this->data['sector'])
            ? $builder
            : $builder->whereHas(
                'employer.sector',
                fn(Builder $builder) => $builder->where('id', $this->data['sector'])
                    ->orWhere('parent_id', $this->data['sector'])
            );
    }
}
