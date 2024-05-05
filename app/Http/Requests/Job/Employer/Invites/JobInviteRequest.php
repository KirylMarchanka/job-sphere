<?php

namespace App\Http\Requests\Job\Employer\Invites;

use App\Http\Requests\Job\BaseJobRequest;

class JobInviteRequest extends BaseJobRequest
{
    public function authorize(): bool
    {
        return $this->user('web.employers')->getKey() === $this->route()->parameter('job')->getAttribute('employer_id');
    }
}
