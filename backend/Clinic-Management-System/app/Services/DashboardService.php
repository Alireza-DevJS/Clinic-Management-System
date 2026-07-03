<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\User;
use App\Models\WorkShift;
use Carbon\Carbon;

class DashboardService
{
    public function getStatistics(): array
    {
        $today = Carbon::today();

        return [

            'appointments' => [

                'today' => Appointment::whereDate('appointment_date', $today)->count(),

                'pending' => Appointment::where('status', AppointmentStatus::Pending)->count(),

                'confirmed' => Appointment::where('status', AppointmentStatus::Confirmed)->count(),

                'completed' => Appointment::where('status', AppointmentStatus::Completed)->count(),

                'cancelled' => Appointment::where('status', AppointmentStatus::Cancelled)->count(),

                'total' => Appointment::count(),
            ],

            'patients' => [

                'total' => User::where('role', 'client')->count(),

                'new_today' => User::where('role', 'client')
                    ->whereDate('created_at', $today)
                    ->count(),
            ],
            'today_schedule' => $this->todaySchedule(),
            'weekly_appointments' => $this->weeklyAppointments(),
            'busy_slots' => $this->busySlots(),

        ];
    }
    public function todaySchedule(): array
{
    $today = Carbon::today();

    $shift = WorkShift::where('day_of_week', $today->dayOfWeek)->first();

    if (!$shift) {
        return [];
    }

    $appointments = Appointment::query()
        ->with('user')
        ->whereDate('appointment_date', $today)
        ->whereIn('status', [
            AppointmentStatus::Pending,
            AppointmentStatus::Confirmed,
        ])
        ->orderBy('appointment_date')
        ->get();

    return $appointments->map(function ($appointment) {
        return [
            'id' => $appointment->id,
            'time' => Carbon::parse($appointment->appointment_date)->format('H:i'),
            'patient' => $appointment->user->name,
            'status' => $appointment->status->value,
            'status_label' => $appointment->status->label(),
        ];
    })->toArray();
}
public function weeklyAppointments(): array
{
    $data = [];

    for ($i = 6; $i >= 0; $i--) {

        $date = Carbon::today()->subDays($i);

        $count = Appointment::whereDate('appointment_date', $date)->count();

        $data[] = [
            'date' => $date->format('Y-m-d'),
            'count' => $count,
        ];
    }

    return $data;
}
public function busySlots(): array
{
    $today = Carbon::today();

    $shift = WorkShift::where('day_of_week', $today->dayOfWeek)->first();

    if (!$shift) {
        return [];
    }

    $start = Carbon::parse($today->format('Y-m-d') . ' ' . $shift->start_time);
    $end   = Carbon::parse($today->format('Y-m-d') . ' ' . $shift->end_time);

    $result = [];

    while ($start < $end) {

        $time = $start->format('H:i');

        $booked = Appointment::whereDate('appointment_date', $today)
            ->whereTime('appointment_date', $time)
            ->whereIn('status', [
                AppointmentStatus::Pending,
                AppointmentStatus::Confirmed,
            ])
            ->count();

        $capacity = $shift->capacity ?? 1;

        $status = match(true) {
            $booked >= $capacity => 'full',
            $booked > 0 => 'partial',
            default => 'free'
        };

        $result[] = [
            'time' => $time,
            'booked' => $booked,
            'capacity' => $capacity,
            'status' => $status,
        ];

        $start->addMinutes($shift->visit_duration);
    }

    return $result;
}
}
