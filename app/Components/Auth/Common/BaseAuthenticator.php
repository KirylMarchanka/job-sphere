<?php

namespace App\Components\Auth\Common;

use App\Components\Auth\Interfaces\Authenticator;
use App\Components\JWT\DTO\JWTToken;
use Illuminate\Support\Facades\Auth;

class BaseAuthenticator implements Authenticator
{
    protected string $guard;

    public function authenticate(string $email, string $password): ?JWTToken
    {
        $token = Auth::guard($this->guard)->attempt(['email' => $email, 'password' => $password]);
        if (false === $token) {
            return null;
        }

        return new JWTToken(
            $token,
            'bearer',
            Auth::payload()->get('exp'),
        );
    }
}
