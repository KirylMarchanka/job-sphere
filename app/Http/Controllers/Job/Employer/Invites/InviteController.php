<?php

namespace App\Http\Controllers\Job\Employer\Invites;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Conversation\Repositories\ConversationRepository;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Traits\JobApplyTrait;
use App\Http\Requests\Job\Employer\Invites\JobInviteRequest;
use App\Models\EmployerJob;
use Illuminate\Http\JsonResponse;

class InviteController extends Controller
{
    use JobApplyTrait;

    private string $applyMethod = 'invite';

    public function invite(
        JobInviteRequest $request,
        EmployerJob $job,
        JobApplyRepository $jobApplyRepository,
        ResumeRepository $resumeRepository,
        ConversationRepository $conversationRepository,
        ConversationMessageRepository $messageRepository
    ): JsonResponse
    {
        return $this->sendJobApplyRequest(
            $resumeRepository->get($request->integer('resume')),
            $job,
            $request->user('api.employers'),
            $request->input('message'),
            $jobApplyRepository,
            $conversationRepository,
            $messageRepository
        );
    }
}
