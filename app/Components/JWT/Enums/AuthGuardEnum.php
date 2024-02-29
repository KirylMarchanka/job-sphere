<?php

namespace App\Components\JWT\Enums;

enum AuthGuardEnum: string
{
    case USER = 'api.users';
    case EMPLOYER = 'api.employers';
}
