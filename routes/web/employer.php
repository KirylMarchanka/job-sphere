<?php

use App\Http\Controllers\Auth\Employer\LoginController;
use App\Http\Controllers\Auth\Employer\LogoutController;
use App\Http\Controllers\Auth\Employer\RegisterController;
use App\Http\Controllers\Auth\Employer\VerifyEmailController;
use App\Http\Controllers\Employer\Common\EmployerController;
use App\Http\Controllers\Job\Employer\JobController;
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

Route::prefix('/jobs')->name('jobs.')->middleware('auth:web.employers')->group(function () {
    Route::controller(JobController::class)->group(function () {
        Route::get('/', [JobController::class, 'index'])->name('index');
        Route::get('/create', [JobController::class, 'create'])->name('create');
        Route::post('/', [JobController::class, 'store'])->name('store');
        Route::get('/{job}', [JobController::class, 'edit'])->name('edit');
        Route::put('/{job}', [JobController::class, 'update'])->name('update');
    });
});

Route::controller(EmployerController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{employer}', 'show')->name('show');
});
