<?php

namespace App\Components\Employer\DTO;

class Employer
{
    public readonly string $name;
    public readonly string $email;
    public readonly string $description;
    public readonly ?string $siteUrl;
    public readonly string $password;

    public function __construct(string $name, string $email, string $description, ?string $siteUrl, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->description = $description;
        $this->siteUrl = $siteUrl;
        $this->password = $password;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'site_url' => $this->siteUrl,
            'password' => $this->password,
        ];
    }
}
