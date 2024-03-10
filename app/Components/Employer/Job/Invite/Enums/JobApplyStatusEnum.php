<?php

namespace App\Components\Employer\Job\Invite\Enums;

enum JobApplyStatusEnum: int
{
    case WAIT = 0;
    case REJECTED = 1;
    case ACCEPTED = 2;
}
