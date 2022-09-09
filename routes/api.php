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

Route::group(['middleware' => ['api', 'cors']], function ($router) {
    Route::prefix('v1')->group(function () {
        //SMS Routes
        Route::resource('/sms', App\Http\Controllers\Api\SMSController::class);

        //Customer Routes
        Route::put('/customers/reset-pin', [App\Http\Controllers\Api\CustomerController::class, 'resetPin']);
        Route::put('/customers/update-status', [App\Http\Controllers\Api\CustomerController::class,'updateStatus']);
        Route::resource('/customers', App\Http\Controllers\Api\CustomerController::class);
        Route::post('/customers/auth', [App\Http\Controllers\Api\CustomerController::class, 'authenticateCustomer']);
        //Product Routes
        Route::resource('/products', App\Http\Controllers\Api\ProductController::class);

        //Get Product by Category
        Route::get('/products/category/{category}', [App\Http\Controllers\Api\ProductController::class, 'getByCategory']);

        Route::get('/categories', [App\Http\Controllers\Api\CategoryController::class, 'index']);

        Route::resource('/premiums', App\Http\Controllers\Api\PremiumController::class);

        Route::get('/subscriptions/users/{customer_ref}', [App\Http\Controllers\Api\SubscriptionController::class, 'fetchUserSubscriptions']);
        Route::resource('/subscriptions', App\Http\Controllers\Api\SubscriptionController::class);

        Route::resource('/transactions', App\Http\Controllers\Api\TransactionsController::class);
        Route::post('/transactions/callback/{service}', [App\Http\Controllers\Api\TransactionsController::class,'handleCallback']);
        Route::get('/transactions/status/check/{internal_reference}', [App\Http\Controllers\Api\TransactionsController::class, 'checkTxnStatus']);
    });

});


