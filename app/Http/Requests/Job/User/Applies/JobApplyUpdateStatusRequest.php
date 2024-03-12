<?php

namespace App\Http\Requests\Job\User\Applies;

use App\Components\Employer\Job\Invite\Enums\JobApplyStatusEnum;
use App\Components\Employer\Job\Invite\Enums\JobApplyTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobApplyUpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $apply = $this->route()->parameter('apply');

        return $apply->getAttribute('type') === JobApplyTypeEnum::INVITE->value
            && $apply->getAttribute('status') === JobApplyStatusEnum::WAIT->value
            && $this->user('api.users')
                ->resumes()
                ->where('id', $apply->getAttribute('resume_id'))
                ->exists();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'integer', 'numeric', 'min:1', Rule::enum(JobApplyStatusEnum::class)],
            'message' => ['required', 'string', 'max:1500'],
        ];
    }
}
