<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UpdateAppointmentStatusRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;


class AppointmentController extends ApiController
{
     public function index()
    {
        $appointments = Appointment::with('user')->latest()->paginate(20);
        return $this->successResponse(AppointmentResource::collection($appointments), 200, 'لیست نوبت‌ها دریافت شد');
    }

   public function updateStatus(UpdateAppointmentStatusRequest $request,Appointment $appointment) {
//    $this->authorize('update', $appointment);
   $appointment->update([
        'status' => $request->validated()['status'],
    ]);

    return $this->successResponse(
        new AppointmentResource($appointment),
        200,
        'وضعیت نوبت با موفقیت تغییر کرد.'
    );
}
}
