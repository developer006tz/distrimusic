<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SocialMediaPlatformController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);
        Route::resource(
            'social-media-platforms',
            SocialMediaPlatformController::class
        );
        Route::resource('services', ServiceController::class);
        Route::resource('vendors', VendorController::class);
        Route::resource('transactions', TransactionController::class);
        Route::resource('orders', OrderController::class);
    });
