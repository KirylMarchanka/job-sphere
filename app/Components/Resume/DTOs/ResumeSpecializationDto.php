<?php

namespace App\Components\Resume\DTOs;

class ResumeSpecializationDto
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
