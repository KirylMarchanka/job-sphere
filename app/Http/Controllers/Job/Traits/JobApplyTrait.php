<?php

namespace App\Http\Controllers\Job\Traits;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Conversation\Repositories\ConversationRepository;
use App\Components\Employer\Job\Invite\Enums\JobApplyStatusEnum;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Components\Responser\Facades\Responser;
use App\Models\Employer;
use App\Models\EmployerJob;
use App\Models\Interfaces\SenderInterface;
use App\Models\JobApply;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Http\JsonResponse;

trait JobApplyTrait
{
    public function sendJobApplyRequest(
        Resume $resume,
        EmployerJob $job,
        SenderInterface $sender,
        string $message,
        JobApplyRepository $jobApplyRepository,
        ConversationRepository $conversationRepository,
        ConversationMessageRepository $messageRepository
    ): JsonResponse
    {
        /** @var JobApply $invite */
        $invite = $jobApplyRepository->setResume($resume)->setJob($job)->{$this->applyMethod}();
        $conversation = $conversationRepository
            ->setApply($invite)
            ->store(sprintf('Отклик на вакансию %s', $job->getAttribute('title')));

        $messageRepository->setConversation($conversation)->send($sender, $message);

        return Responser::wrap(false)->setData(['success' => true])->success();
    }

    public function changeApplyStatus(
        SenderInterface $sender,
        JobApply $apply,
        JobApplyStatusEnum $status,
        string $message,
        JobApplyRepository $jobApplyRepository,
        ConversationMessageRepository $messageRepository
    ): JsonResponse
    {
        $jobApplyRepository->setApply($apply)->update($status);
        $conversation = $apply->conversation()->first();
        if (null === $conversation) {
            return Responser::wrap(false)->setData(['success' => true])->success();
        }

        $messageRepository->setConversation($conversation)
            ->readAllMessages($sender instanceof User ? Employer::class : User::class);
        $messageRepository->send($sender, $message);

        return Responser::wrap(false)->setData(['success' => true])->success();
    }
}
