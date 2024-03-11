<?php

namespace App\Http\Controllers\Employer\Job\Employer\Invites;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Employer\Job\Invite\Enums\JobApplyStatusEnum;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\Job\Employer\Invites\JobInviteUpdateStatusRequest;
use App\Models\JobApply;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class JobInviteStatusController extends Controller
{
    public function update(
        JobInviteUpdateStatusRequest $request,
        JobApply $apply,
        JobApplyRepository $jobApplyRepository,
        ConversationMessageRepository $messageRepository
    ): JsonResponse
    {
        $jobApplyRepository->setApply($apply)->update(JobApplyStatusEnum::from($request->integer('status')));
        $conversation = $jobApplyRepository->findRelatedConversation();
        if (null === $conversation) {
            return Responser::wrap(false)->setData(['success' => true])->success();
        }

        $messageRepository->setConversation($conversation)->readAllMessages(User::class);
        $messageRepository->send($request->user('api.employers'), $request->input('message'));

        return Responser::wrap(false)->setData(['success' => true])->success();
    }
}
