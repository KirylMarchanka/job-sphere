<?php

namespace App\Components\Employer\Job\Invite\Repositories;

use App\Components\Employer\Job\Invite\Enums\JobApplyStatusEnum;
use App\Components\Employer\Job\Invite\Enums\JobApplyTypeEnum;
use App\Models\EmployerJob;
use App\Models\JobApply;
use App\Models\Resume;

class JobApplyRepository
{
    private Resume $resume;
    private EmployerJob $job;

    public function setResume(Resume $resume): JobApplyRepository
    {
        $this->resume = $resume;
        return $this;
    }

    public function setJob(EmployerJob $job): JobApplyRepository
    {
        $this->job = $job;
        return $this;
    }

    public function invite(): JobApply
    {
        return $this->createJobApply(JobApplyTypeEnum::INVITE);
    }

    public function apply(): JobApply
    {
        return $this->createJobApply(JobApplyTypeEnum::APPLY);
    }

    private function createJobApply(JobApplyTypeEnum $type): JobApply
    {
        return $this->job->applies()->create([
            'resume_id' => $this->resume->getKey(),
            'type' => $type->value,
            'status' => JobApplyStatusEnum::WAIT->value,
        ]);
    }
}
