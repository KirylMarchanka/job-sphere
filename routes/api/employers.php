<?php

use App\Http\Controllers\Auth\Employer\LoginController;
use App\Http\Controllers\Auth\Employer\RegisterController;
use App\Http\Controllers\Auth\Employer\VerifyEmailController;
use App\Http\Controllers\Employer\Job\Employer\Invites\InviteController;
use App\Http\Controllers\Employer\Job\Employer\Invites\InviteStatusController;
use App\Http\Controllers\Employer\Job\Employer\JobArchiveStateController;
use App\Http\Controllers\Employer\Job\Employer\JobController;
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

Route::prefix('/jobs')
    ->name('jobs.')
    ->middleware('auth:api.employers')
    ->group(function () {
        Route::post('/', [JobController::class, 'store'])->name('store');

        Route::put('/applies/{apply}/update-status', [InviteStatusController::class, 'update'])
            ->name('applies.update-status');

        Route::prefix('/{job}')->group(function () {
            Route::patch('/', [JobController::class, 'update'])->name('update');

            Route::controller(JobArchiveStateController::class)->group(function () {
                Route::put('/archive', 'archive')->name('archive');
                Route::put('/unarchive', 'unarchive')->name('unarchive');
            });

            Route::post('/invite', [InviteController::class, 'invite'])->name('invite');
        });
    });
