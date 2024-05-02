<?php

namespace App\Http\Requests\Job\User\Applies;

use App\Http\Requests\Job\BaseJobRequest;

class JobApplyRequest extends BaseJobRequest
{
    public function authorize(): bool
    {
        return $this->user('web.users')->resumes()->where('id', $this->input('resume'))->exists();
    }
}
