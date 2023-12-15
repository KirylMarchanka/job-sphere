<?php

namespace App\Components\JWT\DTO;

class JWTToken
{
    private string $token;
    private string $type;
    private int $expiresAt;

    public function __construct(string $token, string $type, int $expiresIn)
    {
        $this->token = $token;
        $this->type = $type;
        $this->expiresAt = $expiresIn;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'type' => $this->type,
            'expires_at' => $this->expiresAt,
        ];
    }
}
