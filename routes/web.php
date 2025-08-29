<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'server_status' => 'running',
        'message' => 'Simple Service Booking System API is up and running'
    ], 200);
});
