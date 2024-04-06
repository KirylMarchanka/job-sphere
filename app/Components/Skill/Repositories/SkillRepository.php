<?php

namespace App\Components\Skill\Repositories;

use App\Models\Skill;

class SkillRepository
{
    public function all(): array
    {
        return Skill::query()->get()->toArray();
    }
}
