<?php

namespace App\Http\Controllers\Auth\Common;

use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LogoutController extends Controller
{
    public function logout(): JsonResponse
    {
        foreach (['api.users', 'api.employers'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        return Responser::setData(['message' => Lang::get('auth.logout.success')])->success();
    }
}
