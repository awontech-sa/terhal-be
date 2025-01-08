<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ConfirmEmailController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourGuideController;
use Illuminate\Support\Facades\Route;

// start admin routes
Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::post('/admin/add-event', [AdminController::class, 'create']);
    Route::post('/admin/create-event-type', [AdminController::class, 'createEventType']);
    Route::post('/admin/add-product-type', [AdminController::class, 'createProduct']);
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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('confirm-email/send-otp', [ConfirmEmailController::class, 'sendOTP'])->middleware('auth:sanctum');
Route::post('confirm-email', [ConfirmEmailController::class, 'verifyEmail'])->middleware('auth:sanctum');

Route::post('/password-reset/send-otp', [PasswordResetController::class, 'sendOTP']);
Route::post('/password-reset', [PasswordResetController::class, 'resetPassword']);

// end auth routes

// start events routes
Route::get('events/{id}', [EventController::class, 'show']);
Route::get('event-type', [EventTypeController::class, 'index']);
Route::get('events', [EventController::class, 'index']);
// end events routes

// start tours routes
Route::get('/tours', [TourController::class, 'index']);   //with date request
Route::get('/top-tours', [TourController::class, 'show']);
Route::get('/tour/{id}', [TourController::class, 'tour']);

// حجز الجولة
Route::post('/tour/booking', [TourController::class, 'booking'])->middleware('auth:sanctum');
Route::get('/tour/booking/{id}', [TourController::class, 'bookingShow'])->middleware('auth:sanctum');
// end tours routes

// start store routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
// end store routes

// start setting routes
Route::get('/setting/about', [SettingController::class, 'index']);
Route::get('/setting/terms-conditions', [SettingController::class, 'show']);
Route::get('/setting/policies', [SettingController::class, 'policies']);
// end setting routes

Route::get('/search', [SearchController::class, 'show']);
