<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
        'appointments' => $this['appointments'],
        'patients' => $this['patients'],
        'today_schedule' => $this['today_schedule'] ?? [],
        'weekly_appointments' => $this['weekly_appointments'] ?? [],
        'busy_slots' => $this['busy_slots'] ?? [],
    ];
    }
}
