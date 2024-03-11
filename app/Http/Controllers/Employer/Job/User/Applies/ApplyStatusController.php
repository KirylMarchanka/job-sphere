<?php

namespace App\Http\Controllers\Employer\Job\User\Applies;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Employer\Job\Invite\Enums\JobApplyStatusEnum;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\Job\Traits\JobApplyTrait;
use App\Http\Requests\Employer\Job\Employer\Invites\JobInviteUpdateStatusRequest;
use App\Http\Requests\Employer\Job\User\Applies\JobApplyUpdateStatusRequest;
use App\Models\Employer;
use App\Models\JobApply;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ApplyStatusController extends Controller
{
    use JobApplyTrait;

    public function update(
        JobApplyUpdateStatusRequest $request,
        JobApply $apply,
        JobApplyRepository $jobApplyRepository,
        ConversationMessageRepository $messageRepository
    ): JsonResponse
    {
        return $this->changeApplyStatus(
            $request->user('api.users'),
            $apply,
            JobApplyStatusEnum::from($request->integer('status')),
            $request->input('message'),
            $jobApplyRepository,
            $messageRepository
        );
    }
}
