<?php

namespace App\Components\Employer\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SectorFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return empty($this->data['sector'])
            ? $builder
            : $builder->where('sector_id', $this->data['sector'])->orWhereHas(
                'sector',
                fn(Builder $builder) => $builder->where('parent_id', $this->data['sector'])
            );
    }
}
