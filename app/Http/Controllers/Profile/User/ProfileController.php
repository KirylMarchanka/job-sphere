<?php

namespace App\Http\Controllers\Profile\User;

use App\Components\Responser\Facades\Responser;
use App\Components\User\DTO\User as UserDto;
use App\Components\User\Profile\ProfileUpdater;
use App\Components\User\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\User\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        return view('users.profile.show', [
            'user' => $request->user('web.users'),
        ]);
    }

    public function update(UpdateProfileRequest $request, ProfileUpdater $profileUpdater): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $profileUpdater->setUser($user)->update((new UserDto(
            $request->input('name'),
            $request->input('email'),
            $request->whenMissing('mobile_number', fn() => $user->getAttribute('mobile_number'), fn() => $request->input('mobile_number')),
            $request->whenHas('password', fn(string $password) => Hash::make($password), fn() => null)
        )));

        return redirect()->route('users.profile.show');
    }

    public function destroy(Request $request, UserRepository $repository): RedirectResponse
    {
        $repository->delete($request->user()->getAttribute('id'));
        Auth::guard('web.users')->logout();

        return redirect()->route('index');
    }
}
