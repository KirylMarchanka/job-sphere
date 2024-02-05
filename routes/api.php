<?php

use App\Http\Controllers\Auth\User\LoginController;
use App\Http\Controllers\Auth\User\LogoutController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\Auth\User\VerifyEmailController;
use App\Http\Controllers\Profile\User\ProfileController;
use App\Http\Controllers\Resume\Common\SpecializationController;
use App\Http\Controllers\Resume\User\ResumeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/user')->name('user.')->group(function () {
    Route::name('auth.')->group(function () {
        Route::middleware('guest:api')->group(function () {
            Route::post('/login', [LoginController::class, 'login'])->name('login');
            Route::post('/register', [RegisterController::class, 'register'])->name('register');
        });

        Route::middleware('auth:api')->group(function () {
            Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
        });
    });

    Route::prefix('/verification')
        ->name('verification.')
        ->middleware('auth:api')
        ->controller(VerifyEmailController::class)
        ->group(function () {
            Route::get('/', 'show')->name('notice');
            Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
            Route::get('/resend', 'resend')->middleware('throttle:6,1')->name('send');
        });

    Route::prefix('/profile')
        ->name('profile.')
        ->middleware('auth:api')
        ->controller(ProfileController::class)
        ->group(function () {
            Route::get('/', 'show')->name('show');
        });

    Route::prefix('/resumes')
        ->name('resumes.')
        ->middleware('auth:api')
        ->controller(ResumeController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{resume}', 'show')->name('show');
        });
});

Route::prefix('/resumes')->name('resumes.')->group(function () {
    Route::prefix('/specializations')
        ->name('specializations.')
        ->controller(SpecializationController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
});
