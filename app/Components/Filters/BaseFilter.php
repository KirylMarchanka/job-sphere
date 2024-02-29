<?php

namespace App\Components\Filters;

use App\Components\Filters\Interfaces\FilterInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

abstract class BaseFilter implements FilterInterface
{
    protected array $filters;

    protected array $data;
    protected Builder $builder;

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }
}
