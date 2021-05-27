<?php

use App\Http\Controllers\API\Auth\LoginAPIController;
use App\Http\Controllers\API\Auth\RegisterAPIController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DayOffController;
use App\Http\Controllers\DeliveryAreaController;
use App\Http\Controllers\FoodCategoryController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodExtraController;
use App\Http\Controllers\OrderController;
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

Route::prefix('/app')->group(function () {
    Route::post('/login', [LoginAPIController::class, 'login']);
    Route::post('/register', [RegisterAPIController::class, 'create']);
});

Route::middleware(['auth:sanctum', 'verified'])->prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/ordersOfTheDay', [DashboardController::class, 'ordersOfTheDay'])->name('ordersOfTheDay');

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('can:user:read')->name('user.index');
        Route::get('/form', [UserController::class, 'form'])->middleware('can:user:create')->name('user.form.create');
        Route::get('/form/{user}', [UserController::class, 'form'])->middleware('can:user:update')->name('user.form.update');
    });

    Route::prefix('/work-schedules')->group(function () {
        Route::get('/', [WorkScheduleController::class, 'index'])->middleware('can:workSchedule:read')->name('workSchedule.index');
        Route::get('/form', [WorkScheduleController::class, 'form'])->middleware('can:workSchedule:create')->name('workSchedule.form.create');
        Route::get('/form/{workSchedule}', [WorkScheduleController::class, 'form'])->middleware('can:workSchedule:update')->name('workSchedule.form.update');
    });

    Route::prefix('/day-offs')->group(function () {
        Route::get('/', [DayOffController::class, 'index'])->middleware('can:dayOff:read')->name('dayOff.index');
        Route::get('/form', [DayOffController::class, 'form'])->middleware('can:dayOff:create')->name('dayOff.form.create');
        Route::get('/form/{dayOff}', [DayOffController::class, 'form'])->middleware('can:dayOff:update')->name('dayOff.form.update');
    });

    Route::prefix('/settings')->group(function () {
        Route::get('/form', [SettingsController::class, 'form'])->middleware('can:settings:update')->name('settings.form');
    });

    Route::prefix('/delivery-areas')->group(function () {
        Route::get('/', [DeliveryAreaController::class, 'index'])->middleware('can:deliveryArea:read')->name('deliveryArea.index');
        Route::get('/form', [DeliveryAreaController::class, 'form'])->middleware('can:deliveryArea:create')->name('deliveryArea.form.create');
        Route::get('/form/{deliveryArea}', [DeliveryAreaController::class, 'form'])->middleware('can:deliveryArea:update')->name('deliveryArea.form.update');
    });

    Route::prefix('/food-categories')->group(function () {
        Route::get('/', [FoodCategoryController::class, 'index'])->middleware('can:foodCategory:read')->name('foodCategory.index');
        Route::get('/form', [FoodCategoryController::class, 'form'])->middleware('can:foodCategory:create')->name('foodCategory.form.create');
        Route::get('/form/{foodCategory}', [FoodCategoryController::class, 'form'])->middleware('can:foodCategory:update')->name('foodCategory.form.update');
    });

    Route::prefix('/foods')->group(function () {
        Route::get('/', [FoodController::class, 'index'])->middleware('can:food:read')->name('food.index');
        Route::get('/form', [FoodController::class, 'form'])->middleware('can:food:create')->name('food.form.create');
        Route::get('/form/{food}', [FoodController::class, 'form'])->middleware('can:food:update')->name('food.form.update');
    });

    Route::prefix('/food-extras')->group(function () {
        Route::get('/', [FoodExtraController::class, 'index'])->middleware('can:foodExtra:read')->name('foodExtra.index');
        Route::get('/form', [FoodExtraController::class, 'form'])->middleware('can:foodExtra:create')->name('foodExtra.form.create');
        Route::get('/form/{foodExtra}', [FoodExtraController::class, 'form'])->middleware('can:foodExtra:update')->name('foodExtra.form.update');
    });

    Route::prefix('/orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->middleware('can:order:read')->name('order.index');
        Route::get('/form', [OrderController::class, 'form'])->middleware('can:order:create')->name('order.form.create');
        Route::get('/form/{order}', [OrderController::class, 'form'])->middleware('can:order:update')->name('order.form.update');
    });
});
