<?php

use App\Http\Controllers\API\AddressAPIController;
use App\Http\Controllers\API\Auth\LoginAPIController;
use App\Http\Controllers\API\Auth\RegisterAPIController;
use App\Http\Controllers\API\DeliveryAreaApiController;
use App\Http\Controllers\API\FoodApiController;
use App\Http\Controllers\API\FoodCategoryApiController;
use App\Http\Controllers\API\FoodFavoriteApiController;
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

    Route::get('/deliveryAreas/{zip}', [DeliveryAreaApiController::class, 'index']);
    Route::get('/workSchedule', [WorkScheduleApiController::class, 'index']);
    Route::get('/settings', [SettingsApiController::class, 'index']);

    Route::get('/foodCategories', [FoodCategoryApiController::class, 'index']);

    Route::get('/foods', [FoodApiController::class, 'index'])->name('food.index');
    Route::get('/foods/{foodId}', [FoodApiController::class, 'show'])->name('food.show');
    Route::get('/foods/category/{categoryId}', [FoodApiController::class, 'category'])->name('food.category');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/address', [AddressAPIController::class, 'index']);
        Route::get('/address/{id}', [AddressAPIController::class, 'show']);
        Route::post('/address', [AddressAPIController::class, 'store']);
        Route::patch('/address/{id}', [AddressAPIController::class, 'update']);
        Route::put('/address/default/{id}', [AddressAPIController::class, 'setDefault']);
        Route::delete('/address/{id}', [AddressAPIController::class, 'delete']);

        Route::get('/favorites', [FoodFavoriteApiController::class, 'index'])->name('favorite.index');
        Route::get('/favorites/{favoriteId}', [FoodFavoriteApiController::class, 'show'])->name('favorite.show');
        Route::post('/favorites/{foodId}', [FoodFavoriteApiController::class, 'store'])->name('favorite.store');
        Route::delete('/favorites/{foodFavoriteId}', [FoodFavoriteApiController::class, 'delete'])->name('favorite.delete');
    });

});
