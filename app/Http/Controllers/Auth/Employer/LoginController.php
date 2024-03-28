<?php

namespace App\Http\Controllers\Auth\Employer;

use App\Components\Auth\Employer\EmployerAuthenticator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Employer\LoginRequest;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login.employers');
    }

    public function login(LoginRequest $request, EmployerAuthenticator $authenticator): Response
    {
        return $authenticator->authenticate(
            $request->input('email'),
            $request->input('password'),
            $request->boolean('remember_me')
        );
    }
}
