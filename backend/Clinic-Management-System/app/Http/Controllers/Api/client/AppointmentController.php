<?php

namespace App\Http\Controllers\Api\Client;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Services\AppointmentService;
use App\Services\SlotService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AppointmentController extends ApiController
{
    use AuthorizesRequests;

    public function index()
    {
        $appointments = Appointment::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(4);

        return $this->successResponse(
            AppointmentResource::collection($appointments),
            200,
            'لیست نوبت‌ها دریافت شد.'
        );
    }

   public function store(
    StoreAppointmentRequest $request,
    AppointmentService $appointmentService
) {
    $appointment = $appointmentService->book(
        Carbon::parse(
            $request->validated()['appointment_date']
        ),
        $request->user()->id
    );

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

    public function cancel(Appointment $appointment)
    {
        $this->authorize('cancel', $appointment);

        $appointment->cancel();

        return $this->successResponse(
            new AppointmentResource($appointment),
            200,
            'نوبت با موفقیت لغو شد.'
        );
    }
}
