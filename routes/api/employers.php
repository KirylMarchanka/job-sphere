<?php

use App\Http\Controllers\Auth\Employer\LoginController;
use App\Http\Controllers\Auth\Employer\RegisterController;
use App\Http\Controllers\Auth\Employer\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::middleware('guest:api.employers')->group(function () {
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
    });
});

Route::prefix('/verification')
    ->name('verification.')
    ->middleware('auth:api.employers')
    ->controller(VerifyEmailController::class)
    ->group(function () {
        Route::get('/', 'show')->name('notice');
        Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
        Route::get('/resend', 'resend')->middleware('throttle:6,1')->name('send');
    });
