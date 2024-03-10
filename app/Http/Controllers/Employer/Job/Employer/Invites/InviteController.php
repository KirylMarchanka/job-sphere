<?php

namespace App\Http\Controllers\Employer\Job\Employer\Invites;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Conversation\Repositories\ConversationRepository;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Components\Responser\Facades\Responser;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\Job\Employer\Invites\JobInviteRequest;
use App\Models\Employer;
use App\Models\EmployerJob;
use Illuminate\Http\JsonResponse;

class InviteController extends Controller
{
    public function invite(
        JobInviteRequest $request,
        EmployerJob $job,
        JobApplyRepository $jobApplyRepository,
        ResumeRepository $resumeRepository,
        ConversationRepository $conversationRepository,
        ConversationMessageRepository $messageRepository
    ): JsonResponse
    {
        $resume = $resumeRepository->get($request->integer('resume'));
        $invite = $jobApplyRepository->setResume($resume)->setJob($job)->invite();

        /** @var Employer $employer */
        $employer = $request->user('api.employers');
        $conversation = $conversationRepository
            ->setEmployer($employer->getKey())
            ->setUser($resume->getAttribute('user_id'))
            ->store(
                sprintf('Вы были приглашены на вакансию %s', $job->getAttribute('title')),
                "job_apply_{$invite->getKey()}"
            );

        $messageRepository->setConversation($conversation)->send($employer, $request->input('message'));

        return Responser::wrap(false)->setData(['success' => true])->success();
    }
}
