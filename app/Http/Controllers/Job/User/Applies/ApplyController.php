<?php

namespace App\Http\Controllers\Job\User\Applies;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Conversation\Repositories\ConversationRepository;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Traits\JobApplyTrait;
use App\Http\Requests\Employer\Job\User\Applies\JobApplyRequest;
use App\Models\EmployerJob;
use Illuminate\Http\JsonResponse;

class ApplyController extends Controller
{
    use JobApplyTrait;

    private string $applyMethod = 'apply';

    public function apply(
        JobApplyRequest $request,
        EmployerJob $job,
        ResumeRepository $resumeRepository,
        JobApplyRepository $jobApplyRepository,
        ConversationRepository $conversationRepository,
        ConversationMessageRepository $messageRepository
    ): JsonResponse
    {
        return $this->sendJobApplyRequest(
            $resumeRepository->get($request->integer('resume')),
            $job,
            $request->user('api.users'),
            $request->input('message'),
            $jobApplyRepository,
            $conversationRepository,
            $messageRepository
        );
    }
}
