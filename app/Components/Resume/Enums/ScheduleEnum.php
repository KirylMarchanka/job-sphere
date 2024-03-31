<?php

namespace App\Components\Resume\Enums;

use Illuminate\Support\Facades\Lang;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

enum ScheduleEnum: int
{
    case FULL_DAY = 0;
    case SHIFT = 1;
    case FLEXIBLE = 2;
    case REMOTE = 3;

    public static function translations(int $status): string
    {
        $status = self::tryFrom($status);

        return match ($status) {
            ScheduleEnum::FULL_DAY => Lang::get('resume.schedule.full_day'),
            ScheduleEnum::SHIFT => Lang::get('resume.schedule.shift'),
            ScheduleEnum::FLEXIBLE => Lang::get('resume.schedule.flexible'),
            ScheduleEnum::REMOTE => Lang::get('resume.schedule.remote'),
            default => throw new InvalidArgumentException('Invalid schedule provided', Response::HTTP_INTERNAL_SERVER_ERROR),
        };
    }

    public static function toArray(): array
    {
        return [
            ScheduleEnum::FULL_DAY->value => Lang::get('resume.schedule.full_day'),
            ScheduleEnum::SHIFT->value => Lang::get('resume.schedule.shift'),
            ScheduleEnum::FLEXIBLE->value => Lang::get('resume.schedule.flexible'),
            ScheduleEnum::REMOTE->value => Lang::get('resume.schedule.remote'),
        ];
    }
}
