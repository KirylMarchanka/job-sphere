<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        Auth::guard('web.users')->logout();

        return redirect()->to('/');
    }
}
