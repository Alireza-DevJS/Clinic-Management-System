<?php

namespace App\Http\Resources;

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

            'appointment_date' => [
                'gregorian' => $this->appointment_date->format('Y-m-d H:i:s'),
                'jalali' => $this->jalaliDate($this->appointment_date),
            ],

            'status' => $this->status->value,
            'status_label' => $this->status->label(),

            'patient' => [
                'first_name' => $this->user->name,
                'last_name' => $this->user->last_name,
                'full_name' => $this->user->name . ' ' . $this->user->last_name,

                'mobile' => $this->user->mobile,
                'national_code' => $this->user->national_code,

                'age' => $this->user->birth_date?->age,

                'birth_date' => $this->user->birth_date ? [
                    'gregorian' => $this->user->birth_date->format('Y-m-d'),
                    'jalali' => $this->jalaliDate($this->user->birth_date),
                ] : null,

                'gender' => [
                    'value' => $this->user->gender->value,
                    'label' => $this->user->gender->label(),
                ],
            ],
        ];
    }
    private function jalaliDate($date): ?string
    {
        if (!$date) return null;
        return Jalalian::fromDateTime($date)->format('Y/m/d H:i');
    }
}
