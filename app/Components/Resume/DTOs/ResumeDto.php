<?php

namespace App\Components\Resume\DTOs;

use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Enums\StatusEnum;

class ResumeDto
{
    public string $title;
    public StatusEnum $status;
    public ?int $salary;
    public EmploymentEnum $employment;
    public ScheduleEnum $schedule;
    public ?string $description;

    public function __construct(
        string         $title,
        StatusEnum     $status,
        ?int           $salary,
        EmploymentEnum $employment,
        ScheduleEnum   $schedule,
        ?string        $description
    )
    {
        $this->title = $title;
        $this->status = $status;
        $this->salary = $salary;
        $this->employment = $employment;
        $this->schedule = $schedule;
        $this->description = $description;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'status' => $this->status->value,
            'salary' => $this->salary,
            'employment' => $this->employment->value,
            'schedule' => $this->schedule->value,
            'description' => $this->description,
        ];
    }
}
