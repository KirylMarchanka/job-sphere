<?php

use App\Http\Controllers\Auth\User\LoginController;
use App\Http\Controllers\Auth\User\LogoutController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\Auth\User\VerifyEmailController;
use App\Http\Controllers\Job\Common\JobController;
use App\Http\Controllers\Main\MainPageController;
use App\Http\Controllers\Profile\User\ProfileController;
use App\Http\Controllers\Resume\Common\ResumeController;
use App\Http\Controllers\Resume\Education\User\ResumeEducationController;
use App\Http\Controllers\Resume\User\ResumeController as UserResumeController;
use App\Http\Controllers\Resume\WorkExperience\User\ResumeWorkExperienceController;
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

    Route::prefix('/profile')->name('profile.')->controller(ProfileController::class)->middleware('auth:web.users')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::put('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    Route::prefix('/resumes')
        ->name('resumes.')
        ->middleware('auth:web.users')
        ->group(function () {
            Route::controller(UserResumeController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{resume}', 'show')->name('show');
                    Route::put('/{resume}', 'update')->name('update');
                    Route::delete('/{resume}', 'delete')->name('delete');
                });

            Route::prefix('/{resume}/work-experiences')
                ->name('work-experiences.')
                ->controller(ResumeWorkExperienceController::class)
                ->group(function () {
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{workExperience}/edit', 'edit')->name('edit');
                    Route::delete('/{workExperience}', 'delete')->name('delete');
                    Route::put('/{workExperience}', 'update')->name('update');
                });

            Route::prefix('/{resume}/educations')
                ->name('educations.')
                ->controller(ResumeEducationController::class)
                ->group(function () {
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{education}/edit', 'edit')->name('edit');
                    Route::delete('/{education}', 'delete')->name('delete');
                    Route::put('/{education}', 'update')->name('update');
                });
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

Route::prefix('/resumes')->name('resumes.')->group(function () {
    Route::get('/', [ResumeController::class, 'index'])->name('index');
    Route::get('/{resume}', [ResumeController::class, 'show'])->name('show');
});
