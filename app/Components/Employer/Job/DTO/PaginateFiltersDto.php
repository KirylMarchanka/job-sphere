<?php

namespace App\Components\Employer\Job\DTO;

use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;

class PaginateFiltersDto
{
    public ?bool $isArchived;
    public ?string $title;
    public ?int $sector;
    public ?int $city;
    public ?int $salaryFrom;
    public ?int $salaryTo;
    public ?JobEducationEnum $education;
    public ?EmploymentEnum $employment;
    public ?JobExperienceEnum $experience;
    public ?ScheduleEnum $schedule;
    private ?array $skills;

    public function __construct(
        ?string $title = null,
        ?bool $isArchived = null,
        ?int $sector = null,
        ?int $city = null,
        ?int $salaryFrom = null,
        ?int $salaryTo = null,
        ?JobEducationEnum $education = null,
        ?EmploymentEnum $employment = null,
        ?JobExperienceEnum $experience = null,
        ?ScheduleEnum $schedule = null,
        ?array $skills = null,
    )
    {
        $this->title = $title;
        $this->isArchived = $isArchived;
        $this->sector = $sector;
        $this->city = $city;
        $this->salaryFrom = $salaryFrom;
        $this->salaryTo = $salaryTo;
        $this->education = $education;
        $this->employment = $employment;
        $this->experience = $experience;
        $this->schedule = $schedule;
        $this->skills = $skills;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'is_archived' => $this->isArchived,
            'sector' => $this->sector,
            'city' => $this->city,
            'salary_from' => $this->salaryFrom,
            'salary_to' => $this->salaryTo,
            'education' => $this->education?->value,
            'employment' => $this->employment?->value,
            'experience' => $this->experience?->value,
            'schedule' => $this->schedule?->value,
            'skills' => $this->skills,
        ];
    }
}
