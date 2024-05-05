<?php

namespace App\Http\Controllers\Job\User\Applies;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Employer\Job\Invite\Enums\JobApplyStatusEnum;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Traits\JobApplyTrait;
use App\Http\Requests\Job\User\Applies\JobApplyUpdateStatusRequest;
use App\Models\JobApply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ApplyStatusController extends Controller
{
    use JobApplyTrait;

    public function update(
        JobApplyUpdateStatusRequest $request,
        JobApply $apply,
        JobApplyRepository $jobApplyRepository,
        ConversationMessageRepository $messageRepository
    ): RedirectResponse
    {
        $this->changeApplyStatus(
            $request->user('web.users'),
            $apply,
            JobApplyStatusEnum::from($request->integer('status')),
            $request->input('message'),
            $jobApplyRepository,
            $messageRepository
        );

        return redirect()->route('users.invites-and-applies.show', [
            'apply' => $apply->getKey(),
        ])->with('notification', ['message' => 'Сообщение отправлено работодателю.']);
    }
}
