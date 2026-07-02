<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class AppointmentResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user_name' => $this->user?->name,
            'appointment_date' => [
                'gregorian' => $this->appointment_date,
                'jalali' => $this->jalaliDate($this->appointment_date),
            ],
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
        ];
    }
    private function jalaliDate($date): ?string
    {
        if (!$date) return null;
        return Jalalian::fromDateTime($date)->format('Y/m/d H:i');
    }
}
