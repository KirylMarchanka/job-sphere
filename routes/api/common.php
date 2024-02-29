<?php

use App\Http\Controllers\Auth\Common\LogoutController;
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
    Route::prefix('/specializations')
        ->name('specializations.')
        ->controller(SpecializationController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
});
