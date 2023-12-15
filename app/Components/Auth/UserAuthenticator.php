<?php

namespace App\Components\Auth;

use App\Components\JWT\DTO\JWTToken;
use Illuminate\Support\Facades\Auth;

class UserAuthenticator
{
    public function authenticate(string $email, string $password): ?JWTToken
    {
        $token = Auth::attempt(['email' => $email, 'password' => $password]);
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
