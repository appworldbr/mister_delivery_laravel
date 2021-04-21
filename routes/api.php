<?php

use App\Http\Controllers\API\AddressAPIController;
use App\Http\Controllers\API\Auth\LoginAPIController;
use App\Http\Controllers\API\Auth\RegisterAPIController;
use App\Http\Controllers\API\DeliveryAreaApiController;
use App\Http\Controllers\API\FoodCategoryApiController;
use App\Http\Controllers\API\SettingsApiController;
use App\Http\Controllers\API\WorkScheduleApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::prefix('/v1.0')->group(function () {

    Route::prefix('/user')->group(function () {
        Route::post('/login', [LoginAPIController::class, 'login']);
        Route::post('/register', [RegisterAPIController::class, 'create']);
    });

    Route::get('/deliveryArea/{zip}', [DeliveryAreaApiController::class, 'index']);
    Route::get('/workSchedule', [WorkScheduleApiController::class, 'index']);
    Route::get('/settings', [SettingsApiController::class, 'index']);
    Route::get('/foodCategories', [FoodCategoryApiController::class, 'index']);

    Route::middleware('auth:sanctum')->prefix('/address')->group(function () {
        Route::get('/', [AddressAPIController::class, 'index']);
        Route::get('/{id}', [AddressAPIController::class, 'show']);
        Route::post('/', [AddressAPIController::class, 'store']);
        Route::patch('/{id}', [AddressAPIController::class, 'update']);
        Route::put('/default/{id}', [AddressAPIController::class, 'setDefault']);
        Route::delete('/{id}', [AddressAPIController::class, 'delete']);
    });

});
