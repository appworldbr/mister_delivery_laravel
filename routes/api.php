<?php

use App\Http\Controllers\API\AddressAPIController;
use App\Http\Controllers\API\CartApiController;
use App\Http\Controllers\API\DeliveryAreaApiController;
use App\Http\Controllers\API\FoodApiController;
use App\Http\Controllers\API\FoodCategoryApiController;
use App\Http\Controllers\API\FoodFavoriteApiController;
use App\Http\Controllers\API\OrderApiController;
use App\Http\Controllers\API\SettingsApiController;
use App\Http\Controllers\API\TelephoneApiController;
use App\Http\Controllers\API\UserApiController;
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

Route::prefix('/v1')->group(function () {

    Route::get('/deliveryArea/{zip}', [DeliveryAreaApiController::class, 'index']);
    Route::get('/workSchedule', [WorkScheduleApiController::class, 'index']);
    Route::get('/settings', [SettingsApiController::class, 'index']);

    Route::get('/foodCategories', [FoodCategoryApiController::class, 'index']);

    Route::get('/food', [FoodApiController::class, 'index'])->name('food.index');
    Route::get('/food/image/{path}', [FoodApiController::class, 'image'])->name('food.image');
    Route::get('/food/{foodId}', [FoodApiController::class, 'show'])->name('food.show');
    Route::get('/food/category/{categoryId}', [FoodApiController::class, 'category'])->name('food.category');

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', [UserApiController::class, 'index']);

        Route::get('/address', [AddressAPIController::class, 'index']);
        Route::get('/address/{id}', [AddressAPIController::class, 'show']);
        Route::post('/address', [AddressAPIController::class, 'store']);
        Route::patch('/address/{id}', [AddressAPIController::class, 'update']);
        Route::put('/address/default/{id}', [AddressAPIController::class, 'setDefault']);
        Route::delete('/address/{id}', [AddressAPIController::class, 'delete']);

        Route::get('/telephone', [TelephoneApiController::class, 'index']);
        Route::get('/telephone/{id}', [TelephoneApiController::class, 'show']);
        Route::post('/telephone', [TelephoneApiController::class, 'store']);
        Route::patch('/telephone/{id}', [TelephoneApiController::class, 'update']);
        Route::put('/telephone/default/{id}', [TelephoneApiController::class, 'setDefault']);
        Route::delete('/telephone/{id}', [TelephoneApiController::class, 'delete']);

        Route::get('/favorite', [FoodFavoriteApiController::class, 'index'])->name('favorite.index');
        Route::get('/favorite/{favoriteId}', [FoodFavoriteApiController::class, 'show'])->name('favorite.show');
        Route::post('/favorite', [FoodFavoriteApiController::class, 'store'])->name('favorite.store');
        Route::patch('/favorite/{favoriteId}', [FoodFavoriteApiController::class, 'update'])->name('favorite.update');
        Route::delete('/favorite/{favoriteId}', [FoodFavoriteApiController::class, 'delete'])->name('favorite.delete');

        Route::get('/cart', [CartApiController::class, 'index'])->name('cart.index');
        Route::get('/cart/{cartId}', [CartApiController::class, 'show'])->name('cart.show');
        Route::post('/cart', [CartApiController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{cartId}', [CartApiController::class, 'update'])->name('cart.update');
        Route::put('/cart/{cartId}/increment', [CartApiController::class, 'increment'])->name('cart.increment');
        Route::put('/cart/{cartId}/decrement', [CartApiController::class, 'decrement'])->name('cart.decrement');
        Route::delete('/cart/clear', [CartApiController::class, 'clear'])->name('cart.clear');
        Route::delete('/cart/{cartId}', [CartApiController::class, 'delete'])->name('cart.delete');

        Route::get('/order', [OrderApiController::class, 'index'])->name('order.index');
        Route::get('/order/{orderId}', [OrderApiController::class, 'show'])->name('order.show');
        Route::post('/order', [OrderApiController::class, 'store'])->name('order.store');
        Route::put('/order/{orderId}/cancel', [OrderApiController::class, 'cancel'])->name('order.cancel');
    });

});
