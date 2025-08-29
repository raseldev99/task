<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[LoginController::class,'login'])->name('login');
Route::post('/register',[RegistrationController::class,'register']);


//admin routes
Route::middleware(['auth:sanctum','role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('services', ServiceController::class)->except('show');
});
