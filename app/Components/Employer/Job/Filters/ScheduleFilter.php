<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\BaseFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ScheduleFilter extends BaseFilter
{
    public function apply(Builder $builder): Builder
    {
        return $builder->when(
            !empty($this->data['schedule']),
            fn(Builder $builder) => $builder->where('schedule', $this->data['schedule'])
        );
    }
}
