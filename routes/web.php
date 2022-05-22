<?php
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



Route::get('/login', function(){
    return view('pages.users.login')->with([
        'title'=>'Login'
    ]);
})->name('login');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/', function(){ return redirect()->route('dashboard');})->name('root');

Route::resource('/customers', App\Http\Controllers\CustomerController::class);
Route::resource('/products', App\Http\Controllers\ProductController::class);

Route::prefix('users')->group(function(){
    Route::resource('/', App\Http\Controllers\UsersController::class);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('users.login');
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('users.logout');
});

Route::group(['middleware'=>['web','auth']], function(){


});

