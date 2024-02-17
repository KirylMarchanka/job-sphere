<?php

namespace App\Components\Resume\Helpers\DtoFillers;

use App\Components\Resume\DTOs\ResumePersonalInformationDto;
use App\Components\Resume\Personal\Enums\SexEnum;
use App\Models\Resume;
use Carbon\Carbon;

class ResumePersonalInformationDtoFiller
{
    public static function fill(Resume $resume, ?array $personalInformation): ?ResumePersonalInformationDto
    {
        if (null === $personalInformation) {
            return null;
        }

        $resumePersonalInformation = $resume->load('personalInformation')->getRelation('personalInformation');

        return new ResumePersonalInformationDto(
            $personalInformation['name'] ?? $resumePersonalInformation->getAttribute('name'),
            $personalInformation['surname'] ?? $resumePersonalInformation->getAttribute('surname'),
            $personalInformation['middle_name'] ?? $resumePersonalInformation->getAttribute('middle_name'),
            Carbon::parse($personalInformation['birthdate'] ?? $resumePersonalInformation->getRawOriginal('birthdate')),
            SexEnum::from($personalInformation['sex'] ?? $resumePersonalInformation->getRawOriginal('sex')),
            $personalInformation['city_id'] ?? $resumePersonalInformation->getAttribute('city_id'),
        );
    }
}
