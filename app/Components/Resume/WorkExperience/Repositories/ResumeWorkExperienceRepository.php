<?php

namespace App\Components\Resume\WorkExperience\Repositories;

use App\Models\Resume;

class ResumeWorkExperienceRepository
{
    private Resume $resume;

    public function setResume(Resume $resume): static
    {
        $this->resume = $resume;
        return $this;
    }

    public function delete(int $workExperience): void
    {
        $this->resume->workExperiences()->where('id', $workExperience)->delete();
    }
}
