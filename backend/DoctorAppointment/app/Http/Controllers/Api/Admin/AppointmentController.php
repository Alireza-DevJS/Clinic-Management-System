<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends ApiController
{
     public function index()
    {
        $appointments = Appointment::all();
        return $this->successResponse($appointments, 200, 'لیست نوبت‌ها دریافت شد');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
         $request->validate([
        'status' => 'required|in:pending,confirmed,cancelled'
    ]);
    if (!$appointment) {
        return $this->errorResponse('نوبت مورد نظر یافت نشد', 404);
    }

    $appointment->status = $request->status;
    $appointment->save();

    return $this->successResponse($appointment, 200, 'وضعیت نوبت با موفقیت تغییر کرد');
    }
}
