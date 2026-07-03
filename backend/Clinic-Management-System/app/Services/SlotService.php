<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Holiday;
use App\Models\WorkShift;
use Carbon\Carbon;

class SlotService
{
    public function availableSlots(Carbon $date): array
    {
        if (Holiday::whereDate('date', $date)->exists()) {
            return [];
        }

        $shift = WorkShift::where('day_of_week', $date->dayOfWeek)->first();

        if (!$shift) {
            return [];
        }

        $start = Carbon::parse(
            $date->format('Y-m-d') . ' ' . $shift->start_time
        );

        $end = Carbon::parse(
            $date->format('Y-m-d') . ' ' . $shift->end_time
        );

        $slots = [];

        while ($start < $end) {

            $time = $start->format('H:i');

            $bookedCount = Appointment::query()
                ->where('appointment_date', $start)
                ->whereIn('status', [
                    AppointmentStatus::Pending,
                    AppointmentStatus::Confirmed,
                ])
                ->count();

            $capacity = $shift->capacity;

            $status = $bookedCount >= $capacity
                ? 'full'
                : 'available';

            $slots[] = [
                'time' => $time,
                'status' => $status,
                'reason' => $status === 'full'
                    ? 'ظرفیت تکمیل است'
                    : null,
                'capacity' => $capacity,
                'booked_count' => $bookedCount,
            ];

            $start->addMinutes($shift->visit_duration);
        }

        return $slots;
    }
}
