<?php

namespace App\Components\Resume\DTOs;

class ResumeContactOtherSourceDto
{
    public ?string $linkedin;
    public ?string $telegram;

    public function __construct(?string $linkedin, ?string $telegram)
    {
        $this->linkedin = $linkedin;
        $this->telegram = $telegram;
    }

    public function toArray(): array
    {
        return [
            'linkedin' => $this->linkedin,
            'telegram' => $this->telegram,
        ];
    }
}
