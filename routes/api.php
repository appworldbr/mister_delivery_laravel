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

Route::middleware('auth:sanctum')->prefix('address')->group(function () {
    Route::get('/', [App\Http\Controllers\API\AddressAPIController::class, 'index']);
    Route::get('/{id}', [App\Http\Controllers\API\AddressAPIController::class, 'show']);
    Route::post('/', [App\Http\Controllers\API\AddressAPIController::class, 'store']);
    Route::patch('/{id}', [App\Http\Controllers\API\AddressAPIController::class, 'update']);
    Route::put('/default/{id}', [App\Http\Controllers\API\AddressAPIController::class, 'default']);
    Route::delete('/{id}', [App\Http\Controllers\API\AddressAPIController::class, 'delete']);
});

Route::resource('settings', App\Http\Controllers\API\SettingAPIController::class);

Route::resource('user_addresses', App\Http\Controllers\API\UserAddressAPIController::class);

Route::resource('work_schedules', App\Http\Controllers\API\WorkScheduleAPIController::class);

Route::resource('delivery_areas', App\Http\Controllers\API\DeliveryAreaAPIController::class);

Route::resource('food_categories', App\Http\Controllers\API\FoodCategoryAPIController::class);
