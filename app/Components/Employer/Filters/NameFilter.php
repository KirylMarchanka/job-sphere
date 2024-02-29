<?php

namespace App\Components\Employer\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class NameFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return empty($this->data['name'])
            ? $builder
            : $builder->where('name', 'like', "%{$this->data['name']}%");
    }
}
