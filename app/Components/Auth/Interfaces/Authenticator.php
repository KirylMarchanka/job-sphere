<?php

namespace App\Components\Auth\Interfaces;

use App\Components\JWT\DTO\JWTToken;

interface Authenticator
{
    public function authenticate(string $email, string $password): ?JWTToken;
}
