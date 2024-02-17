<?php

namespace App\Components\Resume\Education\Repositories;

use App\Models\Resume;

class ResumeEducationRepository
{
    private Resume $resume;

    public function setResume(Resume $resume): static
    {
        $this->resume = $resume;
        return $this;
    }

    public function delete(int $education): void
    {
        $this->resume->education()->where('id', $education)->delete();
    }
}
