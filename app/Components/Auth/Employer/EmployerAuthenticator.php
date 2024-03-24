<?php

namespace App\Components\Auth\Employer;

use App\Components\Auth\Common\BaseAuthenticator;

class EmployerAuthenticator extends BaseAuthenticator
{
    protected string $guard = 'web.employers';
}
