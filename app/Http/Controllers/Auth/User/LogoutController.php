<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Auth\Common\BaseLogoutController;

class LogoutController extends BaseLogoutController
{
    protected string $guard = 'web.users';
}