<?php

namespace App\Http\Controllers\Auth\User;

use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LogoutController extends Controller
{
    public function logout(): JsonResponse
    {
        Auth::logout();

        return Responser::setData(['message' => Lang::get('auth.logout.success')])->success();
    }
}
