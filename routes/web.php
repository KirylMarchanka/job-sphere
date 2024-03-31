<?php

use App\Http\Controllers\Auth\User\LoginController;
use App\Http\Controllers\Auth\User\LogoutController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\Auth\User\VerifyEmailController;
use App\Http\Controllers\Job\Common\JobController;
use App\Http\Controllers\Main\MainPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainPageController::class, 'index'])->name('index');

Route::prefix('/users')->name('users.')->group(function () {
    Route::name('auth.')->group(function () {
        Route::middleware('guest:web.users')->group(function () {
            Route::get('/login', [LoginController::class, 'show'])->name('login-show');
            Route::post('/login', [LoginController::class, 'login'])->name('login');

            Route::get('/register', [RegisterController::class, 'show'])->name('register-show');
            Route::post('/register', [RegisterController::class, 'register'])->name('register');
        });

        Route::middleware('auth:web.users')->group(function () {
            Route::post('/logout', LogoutController::class)->name('logout');
        });
    });

    Route::name('verification.')->group(function () {
        Route::get('/verify', [VerifyEmailController::class, 'verify'])->name('verify');
    });
});

Route::prefix('/jobs')->name('jobs.')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('index');
});

Route::prefix('/employers')->name('employers.')->group(function () {
    Route::prefix('/{employer}/jobs')->name('jobs.')->group(function () {
        Route::get('/{job}', [JobController::class, 'show'])->name('show');
    });
});
