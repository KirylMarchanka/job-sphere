<?php

namespace App\Http\Controllers\Job\Employer;

use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Job\JobArchiveRequest;
use App\Models\Employer;
use App\Models\EmployerJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class JobArchiveStateController extends Controller
{
    public function archive(JobArchiveRequest $request, EmployerJob $job): RedirectResponse
    {
        return $this->update($job, true);
    }

    public function unarchive(JobArchiveRequest $request, EmployerJob $job): RedirectResponse
    {
        return $this->update($job, false);
    }

    private function update(EmployerJob $job, bool $isArchived): RedirectResponse
    {
        $job->update(['is_archived' => $isArchived]);

        return redirect()->route('employers.jobs.index');
    }
}
