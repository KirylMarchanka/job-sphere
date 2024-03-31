<?php

namespace App\Components\Employer\Job\Enums;

use Illuminate\Support\Facades\Lang;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

enum JobExperienceEnum: int
{
    case NO_EXPERIENCE = 0;
    case BETWEEN_ONE_AND_THREE = 1;
    case BETWEEN_THREE_AND_SIX = 2;
    case MORE_THAN_SIX = 3;

    public static function translations(int $experience): string
    {
        $experience = self::tryFrom($experience);

        return match ($experience) {
            JobExperienceEnum::NO_EXPERIENCE => Lang::get('job.experience.no_experience'),
            JobExperienceEnum::BETWEEN_ONE_AND_THREE => Lang::get('job.experience.between_one_and_three'),
            JobExperienceEnum::BETWEEN_THREE_AND_SIX => Lang::get('job.experience.between_three_and_six'),
            JobExperienceEnum::MORE_THAN_SIX => Lang::get('job.experience.more_than_six'),
            default => throw new InvalidArgumentException('Invalid experience provided', Response::HTTP_INTERNAL_SERVER_ERROR),
        };
    }

    public static function toArray(): array
    {
        return [
            JobExperienceEnum::NO_EXPERIENCE->value => Lang::get('job.experience.no_experience'),
            JobExperienceEnum::BETWEEN_ONE_AND_THREE->value => Lang::get('job.experience.between_one_and_three'),
            JobExperienceEnum::BETWEEN_THREE_AND_SIX->value => Lang::get('job.experience.between_three_and_six'),
            JobExperienceEnum::MORE_THAN_SIX->value => Lang::get('job.experience.more_than_six'),
        ];
    }
}
