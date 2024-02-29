<?php

namespace App\Components\Filters\Interfaces;

use Illuminate\Contracts\Database\Eloquent\Builder;

interface FilterInterface
{
    public function setData(array $data): static;

    public function apply(Builder $builder): Builder;
}
