<?php

namespace App\Components\Auth\Interfaces;

use Symfony\Component\HttpFoundation\Response;

interface Authenticator
{
    public function authenticate(string $email, string $password, bool $remember = false): Response;
}
