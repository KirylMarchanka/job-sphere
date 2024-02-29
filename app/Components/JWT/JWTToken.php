<?php

namespace App\Components\JWT;

use App\Components\JWT\DTO\JWTToken as JWTTokenDTO;
use App\Components\JWT\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class JWTToken
{
    private AuthGuardEnum $guard;

    public function setGuard(AuthGuardEnum $guard): self
    {
        $this->guard = $guard;
        return $this;
    }

    /**
     * Get jwt-token string
     *
     * @param JWTSubject $user
     * @return JWTTokenDTO
     */
    public function generate(JWTSubject $user): JWTTokenDTO
    {
        $token = Auth::guard($this->guard->value)->login($user);

        return new JWTTokenDTO($token, 'bearer', Auth::payload()->get('exp'));
    }

    /**
     * Invalidate current token
     *
     * @return void
     */
    public function invalidate(): void
    {
        Auth::guard($this->guard->value)->logout();
    }
}
