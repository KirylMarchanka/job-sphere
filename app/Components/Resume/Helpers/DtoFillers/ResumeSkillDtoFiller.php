<?php

namespace App\Components\Resume\Helpers\DtoFillers;

use App\Components\Resume\DTOs\ResumeSkillDto;

class ResumeSkillDtoFiller
{
    /**
     * @param array<int> $skills
     * @return array<ResumeSkillDto>|null
     */
    public static function fill(?array $skills): ?array
    {
        if (null === $skills) {
            return null;
        }

        return array_map(fn(int $skill) => new ResumeSkillDto($skill), $skills);
    }
}
