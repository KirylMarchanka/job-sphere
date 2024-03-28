<?php

namespace App\Http\Controllers\Auth\Employer;

use App\Components\Employer\DTO\Employer as EmployerDto;
use App\Components\Employer\Repositories\EmployerRepository;
use App\Components\Employer\Sector\Repositories\SectorRepository;
use App\Components\JWT\Enums\AuthGuardEnum;
use App\Components\JWT\JWTToken;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Employer\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function show(SectorRepository $repository): View
    {
        return view('auth.register.employers', [
            'sectors' => $repository->all(),
        ]);
    }

    public function register(RegisterRequest $request, EmployerRepository $repository): RedirectResponse
    {
        $employer = $repository->store(
            new EmployerDto(
                $request->input('name'),
                $request->integer('sector_id'),
                $request->input('email'),
                $request->input('description'),
                $request->input('site_url'),
                $request->input('password'),
            ),
        );

        Event::dispatch(new Registered($employer));

        return redirect()->route('index')->with('notification', [
            'header' => Lang::get('auth.verify.email.sent-header'),
            'message' => Lang::get('auth.verify.email.sent-body'),
        ]);
    }
}
