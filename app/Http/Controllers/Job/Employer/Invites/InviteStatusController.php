<?php

namespace App\Http\Controllers\Job\Employer\Invites;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Employer\Job\Invite\Enums\JobApplyStatusEnum;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Traits\JobApplyTrait;
use App\Http\Requests\Employer\Job\Employer\Invites\JobInviteUpdateStatusRequest;
use App\Models\JobApply;
use Illuminate\Http\JsonResponse;

class InviteStatusController extends Controller
{
    use JobApplyTrait;

    public function update(
        JobInviteUpdateStatusRequest $request,
        JobApply $apply,
        JobApplyRepository $jobApplyRepository,
        ConversationMessageRepository $messageRepository
    ): JsonResponse
    {
        return $this->changeApplyStatus(
            $request->user('api.employers'),
            $apply,
            JobApplyStatusEnum::from($request->integer('status')),
            $request->input('message'),
            $jobApplyRepository,
            $messageRepository
        );
    }
}
