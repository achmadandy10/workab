<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VisitingController;
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


Route::middleware(['auth:sanctum'])->group(function () {

    Route::middleware(['isAPIAdmin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'profile']);
        Route::post('/admin/update', [AdminController::class, 'updateProfile']);

        Route::get('/admin/shop', [ShopController::class, 'shop']);
        Route::post('/admin/shop/add', [ShopController::class, 'addShop']);
        Route::get('/admin/shop/{id}', [ShopController::class, 'showShop']);
        Route::post('/admin/shop/update/{id}', [ShopController::class, 'updateShop']);
        Route::post('/admin/shop/delete/{id}', [ShopController::class, 'deleteShop']);

        Route::get('/admin/shop/product-detail/{id}', [ProductController::class, 'product']);
        Route::post('/admin/shop/product-add/{id}', [ProductController::class, 'addProduct']);
        Route::post('/admin/shop/product-update/{id}', [ProductController::class, 'updateProduct']);
        Route::post('/admin/shop/product-delete/{id}', [ProductController::class, 'deleteProduct']);

        Route::get('/admin/user', [UserController::class, 'showUser']);
        Route::get('/admin/user/profile/{id}', [UserController::class, 'showProfileUser']);
        Route::post('/admin/user/add', [UserController::class, 'addUser']);
        Route::post('/admin/user/update/{id}', [UserController::class, 'updateUser']);
        Route::post('/admin/user/delete/{id}', [UserController::class, 'deleteUser']);

        Route::get('/admin/attendance', [AttendanceController::class, 'showAttendance']);
        Route::get('/admin/attendance/user/{id}', [AttendanceController::class, 'showUserAttendance']);

        Route::get('/admin/visiting', [VisitingController::class, 'showVisiting']);
        Route::get('/admin/visiting/shop/{id}', [VisitingController::class, 'showShopVisiting']);
    });

    Route::get('/user', [UserController::class, 'profile']);
    Route::post('/user/update', [UserController::class, 'updateProfile']);

    Route::post('/user/attendance-in', [AttendanceController::class, 'clockIn']);
    Route::post('/user/attendance-out', [AttendanceController::class, 'clockOut']);
    Route::get('/user/attendance/history', [AttendanceController::class, 'historyAttendance']);

    Route::post('/user/visiting/shop/{qrcode}', [VisitingController::class, 'shopVisiting']);
    Route::post('/user/visiting/update-stock/shop/{id}', [VisitingController::class, 'updateStockVisiting']);
    Route::get('/user/visiting/history', [VisitingController::class, 'historyVisiting']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
