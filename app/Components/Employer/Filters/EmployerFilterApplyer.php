<?php

namespace App\Components\Employer\Filters;

use App\Components\Filters\FilterApplyer;

class EmployerFilterApplyer extends FilterApplyer
{
    protected string $filtersNamespace = 'App\\Components\\Employer\\Filters';
    protected array $filters = ['Name', 'Sector'];
}
