<?php

namespace App\Http\Requests\Employer\Job\User\Applies;

use App\Http\Requests\Employer\Job\BaseJobRequest;

class JobApplyRequest extends BaseJobRequest
{
    public function authorize(): bool
    {
        return $this->user('api.users')->resumes()->where('id', $this->input('resume'))->exists();
    }
}
