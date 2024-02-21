<?php

namespace App\Components\Resume\DTOs;

class ResumeSkillDto
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
