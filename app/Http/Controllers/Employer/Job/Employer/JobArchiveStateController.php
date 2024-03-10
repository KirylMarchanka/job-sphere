<?php

namespace App\Http\Controllers\Employer\Job\Employer;

use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Models\EmployerJob;
use Illuminate\Http\JsonResponse;

class JobArchiveStateController extends Controller
{
    public function archive(EmployerJob $job): JsonResponse
    {
        return $this->update($job, true);
    }

    public function unarchive(EmployerJob $job): JsonResponse
    {
        return $this->update($job, false);
    }

    private function update(EmployerJob $job, bool $isArchived): JsonResponse
    {
        $job->update(['is_archived' => $isArchived]);

        return Responser::wrap(false)->setData(['success' => true])->success();
    }
}
