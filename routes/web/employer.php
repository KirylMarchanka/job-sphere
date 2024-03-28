<?php

use App\Http\Controllers\Auth\Employer\LoginController;
use App\Http\Controllers\Auth\Employer\LogoutController;
use App\Http\Controllers\Auth\Employer\RegisterController;
use App\Http\Controllers\Auth\Employer\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::middleware('guest:web.employers')->group(function () {
        Route::get('/login', [LoginController::class, 'show'])->name('login-show');
        Route::post('/login', [LoginController::class, 'login'])->name('login');

        Route::get('/register', [RegisterController::class, 'show'])->name('register-show');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
    });

    Route::middleware('auth:web.employers')->group(function () {
        Route::post('/logout', LogoutController::class)->name('logout');
    });
});

Route::name('verification.')->group(function () {
    Route::get('/verify', [VerifyEmailController::class, 'verify'])->name('verify');
});