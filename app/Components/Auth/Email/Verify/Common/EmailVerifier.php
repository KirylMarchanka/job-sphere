<?php

namespace App\Components\Auth\Email\Verify\Common;

use App\Components\JWT\DTO\JWTToken as JWTTokenDto;
use App\Components\JWT\Enums\AuthGuardEnum;
use App\Components\JWT\JWTToken;
use Tymon\JWTAuth\Contracts\JWTSubject;

class EmailVerifier
{
    private JWTSubject $user;
    private bool $emailUpdated = false;
    private JWTToken $JWTToken;

    public function __construct(JWTToken $JWTToken)
    {
        $this->JWTToken = $JWTToken;
    }

    public function setGuard(AuthGuardEnum $guard): self
    {
        $this->JWTToken->setGuard($guard);
        return $this;
    }

    public function setUser(JWTSubject $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function updateEmail(?string $email): self
    {
        if (null === $email || $this->user->getEmailForVerification() === $email) {
            return $this;
        }

        $this->user->update(['email' => $email]);
        $this->emailUpdated = true;

        return $this;
    }

    public function sendVerification(): ?JWTTokenDto
    {
        $this->user->sendEmailVerificationNotification();

        return $this->emailUpdated
            ? $this->JWTToken->generate($this->user)
            : null;
    }
}
