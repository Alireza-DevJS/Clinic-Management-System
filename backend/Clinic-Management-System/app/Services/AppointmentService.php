<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\WorkShift;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function __construct(
        protected SlotService $slotService
    ) {
    }

    public function book(Carbon $date, int $userId): Appointment
    {
        return DB::transaction(function () use ($date, $userId) {

            WorkShift::query()
                ->where('day_of_week', $date->dayOfWeek)
                ->lockForUpdate()
                ->first();

            $slots = $this->slotService->availableSlots($date);

            $slot = collect($slots)->firstWhere(
                'time',
                $date->format('H:i')
            );

            if (!$slot) {
                throw ValidationException::withMessages([
                    'appointment_date' => [
                        'این زمان قابل رزرو نیست.'
                    ],
                ]);
            }

            if ($slot['status'] === 'full') {
                throw ValidationException::withMessages([
                    'appointment_date' => [
                        'ظرفیت این نوبت تکمیل شده است.'
                    ],
                ]);
            }

            return Appointment::create([
                'user_id' => $userId,
                'appointment_date' => $date,
                'status' => AppointmentStatus::Pending,
            ]);
        });
    }
}
