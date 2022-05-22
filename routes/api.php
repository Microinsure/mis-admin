<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    //USSD ENDPOINT
    //Route::post('ussd', [App\Http\Controllers\Api\USSDController::class,'run']);
    //Test sending SMS
    Route::resource('/sms', App\Http\Controllers\Api\SMSController::class);
    Route::put('/customers/update-status', [App\Http\Controllers\Api\CustomerController::class,'updateStatus']);
    Route::resource('/customers', App\Http\Controllers\Api\CustomerController::class);

    Route::resource('/products', App\Http\Controllers\Api\ProductController::class);

});
