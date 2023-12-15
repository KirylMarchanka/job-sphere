<?php

namespace App\Components\JWT;

use App\Components\JWT\DTO\JWTToken as JWTTokenDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JWTToken
{
    private const AUTH_GUARD = 'api';

    /**
     * Get jwt-token string
     *
     * @param User $user
     * @return JWTTokenDTO
     */
    public function generate(User $user): JWTTokenDTO
    {
        $token = Auth::guard(self::AUTH_GUARD)->login($user);

        return new JWTTokenDTO($token, 'bearer', Auth::payload()->get('exp'));
    }

    /**
     * Invalidate current token
     *
     * @return void
     */
    public function invalidate(): void
    {
        Auth::guard(self::AUTH_GUARD)->logout();
    }
}
