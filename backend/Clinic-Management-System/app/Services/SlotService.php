<?php
namespace App\Services;

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

    $start = Carbon::parse($date->format('Y-m-d') . ' ' . $shift->start_time);
    $end   = Carbon::parse($date->format('Y-m-d') . ' ' . $shift->end_time);

    $slots = [];

    $booked = Appointment::whereDate('appointment_date', $date)
        ->select('appointment_date')
        ->get()
        ->groupBy(function ($item) {
            return Carbon::parse($item->appointment_date)->format('H:i');
        });

    while ($start < $end) {

        $time = $start->format('H:i');

        $bookedCount = isset($booked[$time]) ? count($booked[$time]) : 0;

        $capacity = $shift->capacity ?? 1;

        $status = 'available';
        $reason = null;

        if ($bookedCount >= $capacity) {
            $status = 'full';
            $reason = 'ظرفیت تکمیل است';
        }

        $slots[] = [
            'time' => $time,
            'status' => $status,
            'reason' => $reason,
            'capacity' => $capacity,
            'booked_count' => $bookedCount,
        ];

        $start->addMinutes($shift->visit_duration);
    }

    return $slots;
}
}
