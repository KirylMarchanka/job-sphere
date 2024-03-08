<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ArchiveFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return !isset($this->data['is_archived'])
            ? $builder
            : $builder->where('is_archived', $this->data['is_archived']);
    }
}
