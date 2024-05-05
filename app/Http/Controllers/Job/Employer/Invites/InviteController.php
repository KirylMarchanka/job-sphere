<?php

namespace App\Http\Controllers\Job\Employer\Invites;

use App\Components\Conversation\Repositories\ConversationMessageRepository;
use App\Components\Conversation\Repositories\ConversationRepository;
use App\Components\Employer\Job\Invite\Repositories\JobApplyRepository;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Traits\JobApplyTrait;
use App\Http\Requests\Job\Employer\Invites\JobInviteRequest;
use App\Models\Employer;
use App\Models\EmployerJob;
use App\Models\JobApply;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    use JobApplyTrait;

    private string $applyMethod = 'invite';

    public function index(Request $request): View
    {
        /** @var Employer $employer */
        $employer = $request->user('web.employers');
        $jobs = $employer->jobs()->select(['id', 'employer_id', 'title', 'is_archived'])->orderByDesc('is_archived')->with(['applies', 'applies.resume:id,title'])->get();
        $applies = collect();

        $jobs->each(fn(EmployerJob $job) => $job->getRelation('applies')->each(function (JobApply $apply) use ($applies, $job) {
            $apply->setAttribute('employer_id', $job->getAttribute('employer_id'));
            $apply->setAttribute('employer_job_title', $job->getAttribute('title'));
            $apply->setAttribute('employer_job_is_archived', (bool) $job->getAttribute('is_archived'));

            return $applies->push($apply);
        }));

        return view()->make('employers.jobs.invites.index', [
            'jobs' => $jobs,
            'applies' => $applies->sortBy('status'),
        ]);
    }

    public function show(JobApply $apply): View
    {
        $apply->load('conversation.messages.sender');

        return view()->make('employers.jobs.invites.show', [
            'apply' => $apply,
        ]);
    }

    public function invite(
        JobInviteRequest $request,
        EmployerJob $job,
        JobApplyRepository $jobApplyRepository,
        ResumeRepository $resumeRepository,
        ConversationRepository $conversationRepository,
        ConversationMessageRepository $messageRepository
    ): RedirectResponse
    {
        $this->sendJobApplyRequest(
            $resumeRepository->get($request->integer('resume')),
            $job,
            $request->user('web.employers'),
            $request->input('message'),
            $jobApplyRepository,
            $conversationRepository,
            $messageRepository
        );

        return redirect()->route('resumes.show', [
            'resume' => $request->integer('resume'),
        ])->with('notification', ['message' => 'Приглашение отправлено пользователю.']);
    }
}
