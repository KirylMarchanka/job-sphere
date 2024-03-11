<?php

namespace App\Http\Requests\Employer\Job\Employer\Invites;

use App\Http\Requests\Employer\Job\BaseJobRequest;

class JobInviteRequest extends BaseJobRequest
{
    public function authorize(): bool
    {
        return $this->user('api.employers')->getKey() === $this->route()->parameter('job')->getAttribute('employer_id');
    }
}
