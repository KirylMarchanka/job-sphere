<?php

namespace App\Http\Controllers\Main;

use App\Components\Employer\Job\Repositories\JobRepository;
use App\Components\Employer\Repositories\EmployerRepository;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class MainPageController extends Controller
{
    public function index(EmployerRepository $employerRepository, JobRepository $jobRepository): View
    {
        return view()->make('welcome', [
            'employers' => $employerRepository->get(limit: 10),
            'jobs' => $jobRepository->getPreviewJobs(),
        ]);
    }
}
