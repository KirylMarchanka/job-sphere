<?php

namespace App\Components\Resume\Helpers\DtoFillers;

use App\Components\Resume\DTOs\ResumeDto;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Enums\StatusEnum;
use App\Models\Resume;

class ResumeDtoFiller
{
    public static function fill(Resume $resume, array $data): ResumeDto
    {
        return new ResumeDto(
            $data['title'] ?? $resume->getAttribute('title'),
            StatusEnum::from($data['status'] ?? $resume->getRawOriginal('status')),
            array_key_exists('salary', $data) ? $data['salary'] : $resume->getAttribute('salary'),
            EmploymentEnum::from($data['employment'] ?? $resume->getRawOriginal('employment')),
            ScheduleEnum::from($data['schedule'] ?? $resume->getRawOriginal('schedule')),
            array_key_exists('description', $data) ? $data['description'] : $resume->getAttribute('description'),
        );
    }
}
