<?php

namespace App\Components\Auth\Common;

use App\Components\Auth\Interfaces\Authenticator;
use App\Components\JWT\DTO\JWTToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BaseAuthenticator implements Authenticator
{
    protected string $guard;
    protected string $failedRoute;
    protected string $successRoute;

    public function authenticate(string $email, string $password, bool $remember = false): Response
    {
        $success = Auth::guard($this->guard)->attempt(['email' => $email, 'password' => $password], $remember);
        if (!$success) {
            return redirect()->route($this->failedRoute)->withErrors([
                'email' => 'Incorrect email provided',
                'password' => 'Incorrect password provided',
            ])->withInput();
        }

        return redirect()->to($this->successRoute);
    }
}
