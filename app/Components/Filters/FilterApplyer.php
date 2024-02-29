<?php

namespace App\Components\Filters;

use App\Components\Filters\Interfaces\FilterInterface;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use ReflectionException;

abstract class FilterApplyer
{
    protected string $filtersNamespace;
    protected array $filters;

    public function apply(Builder $builder, array $data): Builder
    {
        foreach ($this->filters as $filter) {
            try {
                /** @var FilterInterface $class */
                $class = (new ReflectionClass(sprintf('%s\\%sFilter', $this->filtersNamespace, $filter)))
                    ->newInstance();
            } catch (ReflectionException $e) {
                Log::error('Filters: Unable to create filter', [
                    'namespace' => $this->filtersNamespace,
                    'filter' => $filter,
                    'message' => $e->getMessage(),
                ]);

                continue;
            }

            $builder = $class->setData($data)->apply($builder);
        }

        return $builder;
    }
}
