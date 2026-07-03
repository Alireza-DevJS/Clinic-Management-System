<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Api\Admin\HolidayController;
use App\Http\Controllers\Api\Admin\WorkShiftController;

use App\Http\Controllers\Api\Client\AuthController as ClientAuthController;
use App\Http\Controllers\Api\Client\AppointmentController as ClientAppointmentController;
use App\Http\Controllers\Api\Client\AvailableSlotController;

/*
|--------------------------------------------------------------------------
| Client Authentication
|--------------------------------------------------------------------------
*/

Route::post('/register', [ClientAuthController::class, 'register']);
Route::post('/login', [ClientAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [ClientAuthController::class, 'logout']);

    Route::prefix('client')->group(function () {

        Route::apiResource('appointments', ClientAppointmentController::class);

        Route::patch(
            '/appointments/{appointment}/cancel',
            [ClientAppointmentController::class, 'cancel']
        );

        Route::get(
            '/available-slots',
            [AvailableSlotController::class, 'index']
        );

    });

});

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::prefix('admin')
    ->middleware('auth:sanctum')
    ->group(function () {

        Route::post('/logout', [AdminAuthController::class, 'logout']);

        /*
        |--------------------------------------------------------------------------
        | Work Shifts
        |--------------------------------------------------------------------------
        */

        Route::controller(WorkShiftController::class)->group(function () {

            Route::get('/work-shifts', 'index');
            Route::post('/work-shifts', 'store');
            Route::put('/work-shifts/{workShift}', 'update');
            Route::delete('/work-shifts/{workShift}', 'destroy');

        });

        /*
        |--------------------------------------------------------------------------
        | Holidays
        |--------------------------------------------------------------------------
        */

        Route::controller(HolidayController::class)->group(function () {

            Route::get('/holidays', 'index');
            Route::post('/holidays', 'store');
            Route::delete('/holidays/{holiday}', 'destroy');

        });

        /*
        |--------------------------------------------------------------------------
        | Appointments
        |--------------------------------------------------------------------------
        */

        Route::controller(AdminAppointmentController::class)->group(function () {

            Route::get('/appointments', 'index');

            Route::patch(
                '/appointments/{appointment}/status',
                'updateStatus'
            );

        });

    });
