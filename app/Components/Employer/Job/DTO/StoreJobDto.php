<?php

namespace App\Components\Employer\Job\DTO;

use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;

class StoreJobDto
{
    public string $title;
    public ?int $salaryFrom;
    public ?int $salaryTo;
    public bool $employerPaidTaxes;
    public ?JobExperienceEnum $experience;
    public ?JobEducationEnum $education;
    public ScheduleEnum $schedule;
    public string $description;
    public int $cityId;
    public ?string $street;
    public EmploymentEnum $employment;
    /** @var int[] $skills */
    public array $skills;

    /**
     * @param string $title
     * @param int|null $salaryFrom
     * @param int|null $salaryTo
     * @param bool $employerPaidTaxes
     * @param JobExperienceEnum|null $experience
     * @param JobEducationEnum|null $education
     * @param ScheduleEnum $schedule
     * @param string $description
     * @param int $cityId
     * @param string|null $street
     * @param EmploymentEnum $employment
     * @param array<int> $skills
     */
    public function __construct(
        string $title,
        ?int $salaryFrom,
        ?int $salaryTo,
        bool $employerPaidTaxes,
        ?JobExperienceEnum $experience,
        ?JobEducationEnum $education,
        ScheduleEnum $schedule,
        string $description,
        int $cityId,
        ?string $street,
        EmploymentEnum $employment,
        array $skills
    )
    {
        $this->title = $title;
        $this->salaryFrom = $salaryFrom;
        $this->salaryTo = $salaryTo;
        $this->employerPaidTaxes = $employerPaidTaxes;
        $this->experience = $experience;
        $this->education = $education;
        $this->schedule = $schedule;
        $this->description = $description;
        $this->cityId = $cityId;
        $this->street = $street;
        $this->employment = $employment;
        $this->skills = $skills;
    }
}
