<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\WorkShift;
use App\Models\Appointment;

class SlotService
{
    public static function getAvailableSlots($date)
{
    $date = Carbon::parse($date);

    $shift = WorkShift::where('day_of_week', $date->dayOfWeek)->first();

    if (!$shift) return [];

    $start = Carbon::parse($date->format('Y-m-d') . ' ' . $shift->start_time);
    $end = Carbon::parse($date->format('Y-m-d') . ' ' . $shift->end_time);

    $slots = [];

    while ($start < $end) {
        $slots[] = $start->format('H:i');

        $start->addMinutes($shift->visit_duration);
    }

    $booked = Appointment::whereDate('appointment_date', $date)
        ->pluck('appointment_date')
        ->map(fn($item) => Carbon::parse($item)->format('H:i'))
        ->toArray();

    return array_values(array_diff($slots, $booked));
}
}
