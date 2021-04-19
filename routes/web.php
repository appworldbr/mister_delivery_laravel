<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('can:user:read')->name('users.index');
        Route::get('/form', [UserController::class, 'form'])->middleware('can:user:create')->name('user.form.create');
        Route::get('/form/{user}', [UserController::class, 'form'])->middleware('can:user:update')->name('user.form.update');
    });

    Route::prefix('/work-schedule')->group(function () {
        Route::get('/', [WorkScheduleController::class, 'index'])->middleware('can:workSchedule:read')->name('workSchedule.index');
        Route::get('/form', [WorkScheduleController::class, 'form'])->middleware('can:workSchedule:create')->name('workSchedule.form.create');
        Route::get('/form/{workSchedule}', [WorkScheduleController::class, 'form'])->middleware('can:workSchedule:update')->name('workSchedule.form.update');
    });

    Route::prefix('/settings')->group(function () {
        Route::get('/form', [SettingsController::class, 'form'])->middleware('can:settings:update')->name('settings.form');
    });
});
