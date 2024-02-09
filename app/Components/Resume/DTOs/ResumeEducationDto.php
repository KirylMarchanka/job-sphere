<?php

namespace App\Components\Resume\DTOs;

use App\Components\Resume\Education\Enums\DegreeEnum;
use Carbon\Carbon;

class ResumeEducationDto
{
    public int $educationalInstitutionId;
    public string $department;
    public string $specialization;
    public DegreeEnum $degree;
    public Carbon $startDate;
    public Carbon $endDate;

    public function __construct(
        int        $educationalInstitutionId,
        string     $department,
        string     $specialization,
        DegreeEnum $degree,
        Carbon     $startDate,
        Carbon     $endDate
    )
    {
        $this->educationalInstitutionId = $educationalInstitutionId;
        $this->department = $department;
        $this->specialization = $specialization;
        $this->degree = $degree;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function toArray(): array
    {
        return [
            'educational_institution_id' => $this->educationalInstitutionId,
            'department' => $this->department,
            'specialization' => $this->specialization,
            'degree' => $this->degree->value,
            'start_date' => $this->startDate->setDay(1)->format('Y-m-d'),
            'end_date' => $this->endDate->setDay(1)->format('Y-m-d'),
        ];
    }
}
