<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ApiController;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Holiday;
use App\Models\WorkShift;
use App\Services\SlotService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AppointmentController extends ApiController
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $user = $request->user();
       $appointments = Appointment::query()
        ->where('user_id', $user->id)
        ->latest()
        ->get();
        return $this->successResponse(AppointmentResource::collection($appointments));
    }
   public function store(Request $request)
{
    $request->validate([
        'appointment_date' => 'required|date|after:now',
    ]);

    $date = Carbon::parse($request->appointment_date);

    $availableSlots = SlotService::getAvailableSlots($date);

    if (empty($availableSlots)) {
        return response()->json([
            'message' => 'در این روز امکان رزرو وجود ندارد'
        ], 422);
    }

    if (!in_array($date->format('H:i'), $availableSlots)) {
        return response()->json([
            'message' => 'این زمان معتبر نیست'
        ], 422);
    }
    $appointment = \App\Models\Appointment::create([
        'user_id' => $request->user()->id,
        'appointment_date' => $date,
        'status' => 'pending',
    ]);

    return $this->successResponse(
        new AppointmentResource($appointment->load('user'))
    );
}
    public function show(Request $request, Appointment $appointment)
    {
        $this->authorize('view', $appointment);
    return $this->successResponse(
        new AppointmentResource($appointment->load('user'))
    );
    }
}
