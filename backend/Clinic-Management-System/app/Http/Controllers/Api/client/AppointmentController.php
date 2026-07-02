<?php

namespace App\Http\Controllers\Api\Client;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Services\SlotService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AppointmentController extends ApiController
{
    use AuthorizesRequests;

    public function index()
    {
        $appointments = Appointment::query()
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->paginate(4);

        return $this->successResponse(
            AppointmentResource::collection($appointments),
            200,
            'لیست نوبت‌ها دریافت شد.'
        );
    }

    public function store(StoreAppointmentRequest $request)
    {
        $date = Carbon::parse(
            $request->validated()['appointment_date']
        );

        $availableSlots = SlotService::getAvailableSlots($date);

        if (empty($availableSlots)) {
            return $this->errorResponse(
                'در این روز امکان رزرو وجود ندارد.',
                422
            );
        }

        if (!in_array($date->format('H:i'), $availableSlots, true)) {
            return $this->errorResponse(
                'این زمان قابل رزرو نیست.',
                422
            );
        }

        $appointment = Appointment::create([
            'user_id' => $request->user()->id,
            'appointment_date' => $date,
            'status' => AppointmentStatus::Pending,
        ]);

        return $this->successResponse(
            new AppointmentResource($appointment->load('user')),
            201,
            'نوبت با موفقیت ثبت شد.'
        );
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);

        return $this->successResponse(
            new AppointmentResource($appointment->load('user')),
            200,
            'اطلاعات نوبت دریافت شد.'
        );
    }
}
