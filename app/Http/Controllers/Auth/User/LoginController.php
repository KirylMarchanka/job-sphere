<?php

namespace App\Http\Controllers\Auth\User;

use App\Components\Auth\User\UserAuthenticator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\LoginRequest;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login.users');
    }

    public function login(LoginRequest $request, UserAuthenticator $authenticator): Response
    {
        return $authenticator->authenticate(
            $request->input('email'),
            $request->input('password'),
            $request->boolean('remember_me')
        );
    }
}
