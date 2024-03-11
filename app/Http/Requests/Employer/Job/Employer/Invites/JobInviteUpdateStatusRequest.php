<?php

namespace App\Http\Requests\Employer\Job\Employer\Invites;

use App\Components\Employer\Job\Invite\Enums\JobApplyStatusEnum;
use App\Components\Employer\Job\Invite\Enums\JobApplyTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobInviteUpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $apply = $this->route()->parameter('apply');

        return $apply->getAttribute('type') === JobApplyTypeEnum::APPLY->value
            && $apply->getAttribute('status') === JobApplyStatusEnum::WAIT->value
            && $this->user('api.employers')
                ->jobs()
                ->where('id', $apply->getAttribute('employer_job_id'))
                ->exists();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(JobApplyStatusEnum::class)],
            'message' => ['required', 'string', 'max:1500'],
        ];
    }
}
