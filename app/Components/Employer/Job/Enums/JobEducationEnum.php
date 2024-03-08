<?php

namespace App\Components\Employer\Job\Enums;

use Illuminate\Support\Facades\Lang;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

enum JobEducationEnum: int
{
    case NOT_REQUIRED_OR_NOT_SPECIFIED = 0;
    case SPECIAL_SECONDARY = 1;
    case HIGHER = 3;

    public static function translations(int $education): string
    {
        $education = self::tryFrom($education);

        return match ($education) {
            JobEducationEnum::NOT_REQUIRED_OR_NOT_SPECIFIED => Lang::get('job.education.not_required_or_not_specified'),
            JobEducationEnum::SPECIAL_SECONDARY => Lang::get('job.education.special_secondary'),
            JobEducationEnum::HIGHER => Lang::get('job.education.higher'),
            default => throw new InvalidArgumentException('Invalid education provided', Response::HTTP_INTERNAL_SERVER_ERROR),
        };
    }
}
