<?php

namespace App\Http\Controllers\Auth\Common;

use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

abstract class BaseLogoutController extends Controller
{
    protected string $guard;
    protected string $redirect = '/';

    public function __invoke(): RedirectResponse
    {
        Auth::guard($this->guard)->logout();

        return redirect()->to($this->redirect);
    }
}
