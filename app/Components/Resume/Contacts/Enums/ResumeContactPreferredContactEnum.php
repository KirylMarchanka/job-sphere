<?php

namespace App\Components\Resume\Contacts\Enums;

enum ResumeContactPreferredContactEnum: int
{
    case MOBILE_NUMBER = 0;
    case EMAIL = 1;
    case LINKEDIN = 2;
    case TELEGRAM = 3;
}
