<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\HolidayController;
use App\Http\Controllers\Api\Admin\WorkShiftController;
use App\Http\Controllers\Api\Client\AppointmentController as ClientAppointmentController;
use App\Http\Controllers\Api\Client\AvailableSlotController ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [\App\Http\Controllers\Api\Client\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\Client\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [\App\Http\Controllers\Api\Client\AuthController::class, 'logout']);

     Route::prefix('client')->group(function () {
        Route::apiResource('appointments', ClientAppointmentController::class);
        Route::get('/available-slots', [AvailableSlotController::class, 'index']);
    });

});

//  admin panel
Route::post('/admin/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

     Route::get('/work-shifts', [WorkShiftController::class, 'index']);
        Route::post('/work-shifts', [WorkShiftController::class, 'store']);
        Route::put('/work-shifts/{workShift}', [WorkShiftController::class, 'update']);
        Route::delete('/work-shifts/{workShift}', [WorkShiftController::class, 'destroy']);

    //  تعطیلات رسمی
        Route::get('/holidays', [HolidayController::class, 'index']);
        Route::post('/holidays', [HolidayController::class, 'store']);
        Route::delete('/holidays/{holiday}', [HolidayController::class, 'destroy']);


    // لیست نوبت ها
     Route::get('/appointments', [\App\Http\Controllers\Api\Admin\AppointmentController::class, 'index']);
     Route::patch('/appointments/{appointment}/status', [\App\Http\Controllers\Api\Admin\AppointmentController::class, 'updateStatus']);
});
