<?php

use App\Http\Controllers\Api\Admin\BookingController;
use App\Http\Controllers\Api\Admin\ServiceController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\User\BookingController as UserBookingController;
use App\Http\Controllers\Api\User\ServiceController as UserServiceController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [RegistrationController::class, 'register']);

// user routes
Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/services', [UserServiceController::class, 'index']);
    Route::apiResource('/bookings', UserBookingController::class)->only(['index', 'store']);
});

// admin routes
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('/services', ServiceController::class)->except('show');
    Route::get('/bookings', [BookingController::class, 'index']);
});
