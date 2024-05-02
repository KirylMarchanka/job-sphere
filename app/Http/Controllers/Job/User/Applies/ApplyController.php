<?php

namespace App\Http\Controllers\Job\User\Applies;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Conversation\Repositories\ConversationRepository;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Components\Responser\Facades\Responser;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Traits\JobApplyTrait;
use App\Http\Requests\Job\User\Applies\JobApplyRequest;
use App\Http\Requests\Job\User\Applies\JobApplyShowRequest;
use App\Models\EmployerJob;
use App\Models\JobApply;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    ): RedirectResponse
    {
        $this->sendJobApplyRequest(
            $resumeRepository->get($request->integer('resume')),
            $job,
            $request->user('web.users'),
            $request->input('message'),
            $jobApplyRepository,
            $conversationRepository,
            $messageRepository
        );

        return redirect()->route('employers.jobs.show', [
            'employer' => $job->getAttribute('employer_id'),
            'job' => $job->getKey(),
        ])->with('notification', ['message' => 'Отклик отправлен работодателю.']);
    }

    public function index(Request $request): JsonResponse
    {
        $applies = JobApply::query()->with([
            'employerJob:id,title,salary_from,salary_to,salary_employer_paid_taxes,is_archived',
            'resume:id,title',
        ])->whereHas('resume', function (Builder $builder) use ($request) {
            return $builder->where('user_id', $request->user('api.users')->getKey());
        })->get()->toArray();

        return Responser::setData($applies)->success();
    }

    public function show(JobApplyShowRequest $request, JobApply $apply): JsonResponse
    {
        $apply->loadMissing([
            'resume',
            'employerJob.employer',
            'employerJob.city.country',
            'conversation.messages',
        ]);

        return Responser::setData($apply->toArray())->success();
    }
}
