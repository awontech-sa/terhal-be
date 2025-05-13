<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ConfirmEmailController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourGuideController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

// start admin routes
Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::post('/admin/add-event', [AdminController::class, 'create']);
    Route::post('/admin/create-event-type', [EventTypeController::class, 'create']);
    Route::post('/admin/add-product-type', [ProductTypeController::class, 'create']);
});
// end admin routes

// start tour-guide routes
Route::group(['middleware' => ['auth:sanctum', 'tour-guide']], function () {
    Route::post('/tour-guide/add-tour', [TourGuideController::class, 'create']);
});
// end tour-guide routes

// start store routes
Route::group(['middleware' => ['auth:sanctum', 'store']], function () {
    Route::post('/store/add-product', [StoreController::class, 'create']);
});
// end store routes

// start auth routes
Route::post('register', [AuthController::class, 'register']);  // 3
Route::post('register/send-phone-otp', [AuthController::class, 'sendOtp']);  // 1
Route::post('register/verify-phone-otp', [AuthController::class, 'verifyOtp']);  // 2
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('checkToken', [AuthController::class, 'validateToken'])->middleware('auth:sanctum');

Route::post('confirm-email/send-otp', [ConfirmEmailController::class, 'sendOTP'])->middleware('auth:sanctum');
Route::post('confirm-email', [ConfirmEmailController::class, 'verifyEmail'])->middleware('auth:sanctum');

Route::post('/password-reset/send-otp', [PasswordResetController::class, 'sendOTP']);
Route::post('/password-reset', [PasswordResetController::class, 'resetPassword']);


// end auth routes

// start events routes
Route::get('events/{id}', [EventController::class, 'show']);
Route::get('event-type', [EventTypeController::class, 'index']);
Route::get('events', [EventController::class, 'index']);
Route::post('events/{event}/comment', [EventController::class, 'comment'])->middleware('auth:sanctum');
Route::post('events/{event}/rate', [EventController::class, 'rate'])->middleware('auth:sanctum');
Route::post('events/{event}/favorite', [EventController::class, 'favorite'])->middleware('auth:sanctum');
// end events routes

// start tours routes
Route::get('/tours', [TourController::class, 'index']);   //with date request

Route::get('/top-tours', [TourController::class, 'show']);

Route::get('/tour/{tour}', [TourController::class, 'tour']);
Route::post('/tour/{tour}/favorite', [TourController::class, 'favorite'])->middleware('auth:sanctum');
Route::post('/tour/{tour}/rate', [TourController::class, 'rate'])->middleware('auth:sanctum');
Route::post('/tour/{tour}/comment', [TourController::class, 'comment'])->middleware('auth:sanctum');

Route::put('/tour/status/{tour}/{id}', [TourController::class, 'edit'])->middleware('auth:sanctum');

Route::post('/tour/booking', [TourController::class, 'booking'])->middleware('auth:sanctum');
Route::get('/tour/booking/user', [TourController::class, 'bookingShow'])->middleware('auth:sanctum');
Route::post('/tour/booking/cancel/{id}', [TourController::class, 'cancel'])->middleware('auth:sanctum');
// end tours routes

// start store routes
Route::get('/product-types', [ProductTypeController::class, 'index']);
Route::get('/product-types/{id}', [ProductController::class, 'showProduct']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/cart', [ProductController::class, 'showCart'])->middleware('auth:sanctum');
Route::get('/product/{product}', [ProductController::class, 'show']);
Route::post('/product/{product}/cart', [ProductController::class, 'addProductToCart'])->middleware('auth:sanctum');
Route::post('/product/{product}/favorite', [ProductController::class, 'favorite'])->middleware('auth:sanctum');
Route::put('/product/status/{product}/{id}', [ProductController::class, 'edit'])->middleware('auth:sanctum');
Route::post('/product/cancel/{id}', [TourController::class, 'cancel'])->middleware('auth:sanctum');
// end store routes

// start setting routes
Route::get('/setting/about', [SettingController::class, 'index']);
Route::get('/setting/terms-conditions', [SettingController::class, 'show']);
Route::get('/setting/policies', [SettingController::class, 'policies']);
Route::get('/users', [UsersController::class, 'index']);
// end setting routes
