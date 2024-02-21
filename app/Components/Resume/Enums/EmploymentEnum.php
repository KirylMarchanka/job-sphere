<?php

namespace App\Components\Resume\Enums;

use Illuminate\Support\Facades\Lang;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

enum EmploymentEnum: int
{
    case FULL_TIME = 0;
    case PART_TIME = 1;
    case INTERNSHIP = 2;

    public static function translations(int $status): string
    {
        $status = self::tryFrom($status);

        return match ($status) {
            EmploymentEnum::FULL_TIME => Lang::get('resume.employments.full_time'),
            EmploymentEnum::PART_TIME => Lang::get('resume.employments.part_time'),
            EmploymentEnum::INTERNSHIP => Lang::get('resume.employments.internship'),
            default => throw new InvalidArgumentException('Invalid employment provided', Response::HTTP_INTERNAL_SERVER_ERROR),
        };
    }
}
