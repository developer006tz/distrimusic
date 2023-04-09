<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserOrdersController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ServiceOrdersController;
use App\Http\Controllers\Api\OrderServicesController;
use App\Http\Controllers\Api\OrderTransactionsController;
use App\Http\Controllers\Api\VendorTransactionsController;
use App\Http\Controllers\Api\TransactionVendorsController;
use App\Http\Controllers\Api\SocialMediaPlatformController;
use App\Http\Controllers\Api\SocialMediaPlatformServicesController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Orders
        Route::get('/users/{user}/orders', [
            UserOrdersController::class,
            'index',
        ])->name('users.orders.index');
        Route::post('/users/{user}/orders', [
            UserOrdersController::class,
            'store',
        ])->name('users.orders.store');

        Route::apiResource(
            'social-media-platforms',
            SocialMediaPlatformController::class
        );

        // SocialMediaPlatform Services
        Route::get('/social-media-platforms/{socialMediaPlatform}/services', [
            SocialMediaPlatformServicesController::class,
            'index',
        ])->name('social-media-platforms.services.index');
        Route::post('/social-media-platforms/{socialMediaPlatform}/services', [
            SocialMediaPlatformServicesController::class,
            'store',
        ])->name('social-media-platforms.services.store');

        Route::apiResource('services', ServiceController::class);

        // Service Orders
        Route::get('/services/{service}/orders', [
            ServiceOrdersController::class,
            'index',
        ])->name('services.orders.index');
        Route::post('/services/{service}/orders/{order}', [
            ServiceOrdersController::class,
            'store',
        ])->name('services.orders.store');
        Route::delete('/services/{service}/orders/{order}', [
            ServiceOrdersController::class,
            'destroy',
        ])->name('services.orders.destroy');

        Route::apiResource('vendors', VendorController::class);

        // Vendor Transactions
        Route::get('/vendors/{vendor}/transactions', [
            VendorTransactionsController::class,
            'index',
        ])->name('vendors.transactions.index');
        Route::post('/vendors/{vendor}/transactions/{transaction}', [
            VendorTransactionsController::class,
            'store',
        ])->name('vendors.transactions.store');
        Route::delete('/vendors/{vendor}/transactions/{transaction}', [
            VendorTransactionsController::class,
            'destroy',
        ])->name('vendors.transactions.destroy');

        Route::apiResource('transactions', TransactionController::class);

        // Transaction Vendors
        Route::get('/transactions/{transaction}/vendors', [
            TransactionVendorsController::class,
            'index',
        ])->name('transactions.vendors.index');
        Route::post('/transactions/{transaction}/vendors/{vendor}', [
            TransactionVendorsController::class,
            'store',
        ])->name('transactions.vendors.store');
        Route::delete('/transactions/{transaction}/vendors/{vendor}', [
            TransactionVendorsController::class,
            'destroy',
        ])->name('transactions.vendors.destroy');

        Route::apiResource('orders', OrderController::class);

        // Order Transactions
        Route::get('/orders/{order}/transactions', [
            OrderTransactionsController::class,
            'index',
        ])->name('orders.transactions.index');
        Route::post('/orders/{order}/transactions', [
            OrderTransactionsController::class,
            'store',
        ])->name('orders.transactions.store');

        // Order Service
        Route::get('/orders/{order}/services', [
            OrderServicesController::class,
            'index',
        ])->name('orders.services.index');
        Route::post('/orders/{order}/services/{service}', [
            OrderServicesController::class,
            'store',
        ])->name('orders.services.store');
        Route::delete('/orders/{order}/services/{service}', [
            OrderServicesController::class,
            'destroy',
        ])->name('orders.services.destroy');
    });
