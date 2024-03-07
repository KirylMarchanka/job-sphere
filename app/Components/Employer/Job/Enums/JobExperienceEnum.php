<?php

namespace App\Components\Employer\Job\Enums;

enum JobExperienceEnum: int
{
    case NO_EXPERIENCE = 0;
    case BETWEEN_ONE_AND_THREE = 1;
    case BETWEEN_THREE_AND_SIX = 2;
    case MORE_THAN_SIX = 3;
}
