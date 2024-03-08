<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TitleFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return empty($this->data['title'])
            ? $builder
            : $builder->where('title', 'like', $this->data['title']);
    }
}
