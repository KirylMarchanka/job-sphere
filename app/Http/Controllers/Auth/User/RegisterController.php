<?php

namespace App\Http\Controllers\Auth\User;

use App\Components\User\DTO\User;
use App\Components\User\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class RegisterController extends Controller
{
    public function show(): View
    {
        return view('auth.register.users');
    }

    public function register(RegisterRequest $request, UserRepository $repository): RedirectResponse
    {
        $user = $repository->store(
            new User(
                $request->input('name'),
                $request->input('email'),
                $request->input('mobile_number'),
                Hash::make($request->input('password'))
            )
        );

        Event::dispatch(new Registered($user));

        return redirect()->route('index')->with('notification', [
            'header' => Lang::get('auth.verify.email.sent-header'),
            'message' => Lang::get('auth.verify.email.sent-body'),
        ]);
    }
}
