<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Client\AppointmentController as ClientAppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [\App\Http\Controllers\Api\Client\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\Client\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [\App\Http\Controllers\Api\Client\AuthController::class, 'logout']);

     Route::prefix('client')->group(function () {
        Route::apiResource('appointments', ClientAppointmentController::class);
    });
});

//  admin panel
Route::post('/admin/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // لیست نوبت ها
     Route::get('/appointments', [\App\Http\Controllers\Api\Admin\AppointmentController::class, 'index']);
     Route::patch('/appointments/{appointment}/status', [\App\Http\Controllers\Api\Admin\AppointmentController::class, 'updateStatus']);
});
