<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'day_of_week' => $this->day_of_week->value,
            'day_name' => $this->day_of_week->label(),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'visit_duration' => $this->visit_duration
        ];
    }
}
