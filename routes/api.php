<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[LoginController::class,'login']);
Route::post('/register',[RegistrationController::class,'register']);
