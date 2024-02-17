<?php

namespace App\Components\Resume\Helpers\DtoFillers;

use App\Components\Resume\DTOs\ResumeSpecializationDto;

class ResumeSpecializationDtoFiller
{
    /**
     * @param array<int> $specializations
     * @return array<ResumeSpecializationDto>|null
     */
    public static function fill(?array $specializations): ?array
    {
        if (null === $specializations) {
            return null;
        }

        return array_map(fn(int $specialization) => new ResumeSpecializationDto($specialization), $specializations);
    }
}
