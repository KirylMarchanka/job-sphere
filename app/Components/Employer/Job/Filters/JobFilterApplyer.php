<?php

namespace App\Components\Employer\Job\Filters;

use App\Components\Filters\FilterApplyer;

class JobFilterApplyer extends FilterApplyer
{
    protected string $filtersNamespace = 'App\\Components\\Employer\\Job\\Filters';
    protected array $filters = [
        'Title',
        'Archive',
        'Sector',
        'City',
        'Salary',
        'Education',
        'Employment',
        'Experience',
        'Schedule',
        'Skill'
    ];
}
