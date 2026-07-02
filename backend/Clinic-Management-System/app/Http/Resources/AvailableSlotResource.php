<?php

namespace App\Http\Resources;

use App\Enums\WeekDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class AvailableSlotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Carbon $date */
        $date = $this['date'];

        return [
            'date' => [
                'gregorian' => $date->format('Y-m-d'),
                'jalali' => $this->jalaliDate($date),
            ],

               'day_name' => WeekDay::from($date->dayOfWeek)->label(),

            'available_slots' => $this['slots'],
        ];
    }

    private function jalaliDate(Carbon $date): string
    {
        return Jalalian::fromDateTime($date)->format('Y/m/d');
    }
}
