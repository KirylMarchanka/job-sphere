<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CityFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return empty($this->data['city'])
            ? $builder
            : $builder->where('city_id', $this->data['city']);
    }
}
