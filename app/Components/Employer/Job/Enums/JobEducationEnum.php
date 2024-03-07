<?php

namespace App\Components\Employer\Job\Enums;

enum JobEducationEnum: int
{
    case NOT_REQUIRED_OR_NOT_SPECIFIED = 0;
    case SPECIAL_SECONDARY = 1;
    case HIGHER = 3;
}
