<?php

namespace App\Components\Resume\Education\Enums;

use Illuminate\Support\Facades\Lang;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

enum DegreeEnum: int
{
    case SECONDARY = 0;
    case SPECIAL_SECONDARY = 1;
    case UNFINISHED_HIGHER = 2;
    case HIGHER = 3;
    case BACHELOR = 4;
    case MASTER = 5;
    case CANDIDATE = 6;
    case DOCTOR = 7;


    public static function translations(int $status): string
    {
        $status = self::tryFrom($status);

        return match ($status) {
            DegreeEnum::SECONDARY => Lang::get('resume.education.secondary'),
            DegreeEnum::SPECIAL_SECONDARY => Lang::get('resume.education.special_secondary'),
            DegreeEnum::UNFINISHED_HIGHER => Lang::get('resume.education.unfinished_higher'),
            DegreeEnum::HIGHER => Lang::get('resume.education.higher'),
            DegreeEnum::BACHELOR => Lang::get('resume.education.bachelor'),
            DegreeEnum::MASTER => Lang::get('resume.education.master'),
            DegreeEnum::CANDIDATE => Lang::get('resume.education.candidate'),
            DegreeEnum::DOCTOR => Lang::get('resume.education.doctor'),
            default => throw new InvalidArgumentException('Invalid education provided', Response::HTTP_INTERNAL_SERVER_ERROR),
        };
    }
}
