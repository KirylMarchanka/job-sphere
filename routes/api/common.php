<?php

use App\Http\Controllers\Auth\Common\LogoutController;
use App\Http\Controllers\Employer\Common\EmployerController;
use App\Http\Controllers\Employer\Common\Sector\SectorController;
use App\Http\Controllers\Employer\Job\Common\JobController;
use App\Http\Controllers\Resume\Common\ResumeController;
use App\Http\Controllers\Resume\Common\SpecializationController;
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

Route::name('auth.')->group(function () {
    Route::middleware('auth:api.users,api.employers')->group(function () {
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    });
});

Route::prefix('/resumes')->name('resumes.')->group(function () {
    Route::controller(ResumeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{resume}', 'show')->name('index');
    });

    Route::prefix('/specializations')
        ->name('specializations.')
        ->controller(SpecializationController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
});

Route::prefix('/employers')->name('employers.')->group(function () {
    Route::prefix('/sectors')
        ->name('sectors.')
        ->controller(SectorController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });

    Route::controller(EmployerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{employer_id}', 'show')->name('index');
    });

    Route::prefix('/{employer}')->group(function () {
        Route::prefix('/jobs')
            ->controller(JobController::class)
            ->name('jobs.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{job}', 'show')->scopeBindings()->name('show');
            });
    });
});
