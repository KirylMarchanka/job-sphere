<?php

use App\Http\Controllers\Auth\User\LoginController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\Auth\User\VerifyEmailController;
use App\Http\Controllers\Job\User\Applies\ApplyController;
use App\Http\Controllers\Job\User\Applies\ApplyStatusController;
use App\Http\Controllers\Profile\User\ProfileController;
use App\Http\Controllers\Resume\Education\User\ResumeEducationController;
use App\Http\Controllers\Resume\User\ResumeController;
use App\Http\Controllers\Resume\WorkExperience\User\ResumeWorkExperienceController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::middleware('guest:api.users')->group(function () {
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
    });
});

Route::prefix('/verification')
    ->name('verification.')
    ->middleware('auth:api.users')
    ->controller(VerifyEmailController::class)
    ->group(function () {
        Route::get('/', 'show')->name('notice');
        Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
        Route::get('/resend', 'resend')->middleware('throttle:6,1')->name('send');
    });

Route::prefix('/profile')
    ->name('profile.')
    ->middleware('auth:api.users')
    ->controller(ProfileController::class)
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

Route::prefix('/resumes')
    ->name('resumes.')
    ->middleware('auth:api.users')
    ->group(function () {
        Route::controller(ResumeController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{resume}', 'show')->name('show');
            Route::post('/', 'store')->name('store');
            Route::patch('/{resume}', 'update')->name('update');
            Route::delete('/{resume}', 'delete')->name('delete');
        });

        Route::prefix('/{resume}')->group(function () {
            Route::controller(ResumeEducationController::class)
                ->prefix('/education')
                ->name('education.')
                ->scopeBindings()
                ->group(function () {
                    Route::delete('/{education}', 'delete')->name('delete');
                });

            Route::controller(ResumeWorkExperienceController::class)
                ->prefix('/work_experience')
                ->name('work_experience.')
                ->scopeBindings()
                ->group(function () {
                    Route::delete('/{work_experience}', 'delete')->name('delete');
                });
        });
    });

Route::prefix('/applies')->name('applies.')->middleware('auth:api.users')->group(function () {
    Route::get('/', [ApplyController::class, 'index']);
    Route::get('/{apply}', [ApplyController::class, 'show']);
});

Route::prefix('/jobs')->name('jobs.')->middleware('auth:api.users')->group(function () {
    Route::controller(ApplyController::class)->group(function () {
        Route::post('/{job}/apply', 'apply')->name('apply');
    });

    Route::put('/invites/{apply}/update-status', [ApplyStatusController::class, 'update'])
        ->name('invites.update-status');
});
