<?php

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

// Route::middleware(['auth:api'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('user')->group(function () {
    Route::post('/login', [App\Http\Controllers\API\Auth\LoginAPIController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\API\Auth\RegisterAPIController::class, 'create']);
});

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/address', [App\Http\Controllers\API\UserAPIController::class, 'getAddress']);
    Route::post('/address', [App\Http\Controllers\API\UserAPIController::class, 'storeAddress']);
    Route::patch('/address/{id}', [App\Http\Controllers\API\UserAPIController::class, 'updateAddress']);
    Route::delete('/address/{id}', [App\Http\Controllers\API\UserAPIController::class, 'deleteAddress']);
});

Route::resource('settings', App\Http\Controllers\API\SettingAPIController::class);

Route::resource('user_addresses', App\Http\Controllers\API\UserAddressAPIController::class);

Route::resource('work_schedules', App\Http\Controllers\API\WorkScheduleAPIController::class);

Route::resource('delivery_areas', App\Http\Controllers\API\DeliveryAreaAPIController::class);

Route::resource('food_categories', App\Http\Controllers\API\FoodCategoryAPIController::class);
