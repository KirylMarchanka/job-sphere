<?php

namespace App\Components\Resume\Enums;

use Illuminate\Support\Facades\Lang;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

enum StatusEnum: int
{
    case ACTIVE = 0;
    case OPEN_TO_OPPORTUNITIES = 1;
    case THINKING_ABOUT_NEW_OFFER = 2;
    case ACCEPTED_OFFER = 3;
    case UNAVAILABLE = 4;

    public static function translations(int $status): string
    {
        $status = self::tryFrom($status);

        return match ($status) {
            StatusEnum::ACTIVE => Lang::get('resume.statuses.active'),
            StatusEnum::OPEN_TO_OPPORTUNITIES => Lang::get('resume.statuses.open_to_opportunities'),
            StatusEnum::THINKING_ABOUT_NEW_OFFER => Lang::get('resume.statuses.new_offer'),
            StatusEnum::ACCEPTED_OFFER => Lang::get('resume.statuses.accepted_offer'),
            StatusEnum::UNAVAILABLE => Lang::get('resume.statuses.unavailable'),
            default => throw new InvalidArgumentException('Invalid resume status provided', Response::HTTP_INTERNAL_SERVER_ERROR),
        };
    }
}
