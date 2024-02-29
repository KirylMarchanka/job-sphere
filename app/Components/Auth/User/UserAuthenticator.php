<?php

namespace App\Components\Auth\User;

use App\Components\Auth\Common\BaseAuthenticator;

class UserAuthenticator extends BaseAuthenticator
{
    protected string $guard = 'api.users';
}
