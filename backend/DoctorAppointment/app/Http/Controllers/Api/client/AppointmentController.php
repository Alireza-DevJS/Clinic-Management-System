<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ApiController;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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

        $appointment = Appointment::create([
            'user_id' => $request->user()->id,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
        ]);

        return $this->successResponse(new AppointmentResource($appointment->load('user')));
    }
    public function show(Request $request, Appointment $appointment)
    {
        $this->authorize('view', $appointment);
    return $this->successResponse(
        new AppointmentResource($appointment->load('user'))
    );
    }
}
