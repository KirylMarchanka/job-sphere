<?php

namespace App\Components\User\DTO;

class User
{
    public readonly string $name;
    public readonly string $email;
    public readonly ?string $mobileNumber;
    public readonly ?string $password;

    public function __construct(
        string  $name,
        string  $email,
        ?string $mobileNumber,
        ?string  $password
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobileNumber = $mobileNumber;
        $this->password = $password;
    }

    public function toArray(): array
    {
        $properties = [
            'name' => $this->name,
            'email' => $this->email,
            'mobile_number' => $this->mobileNumber,
        ];

        if (isset($this->password)) {
            $properties['password'] = $this->password;
        }

        return $properties;
    }
}
