<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
   protected $guarded = [];
   public function user()
{
    return $this->belongsTo(User::class);
}
  protected function casts(): array
    {
        return [
            'status' => AppointmentStatus::class,
             'appointment_date' => 'datetime',
        ];
    }
    public function canBeCancelled(): bool
{
    return $this->status === AppointmentStatus::Pending;
}

public function cancel(): void
{
    $this->update([
        'status' => AppointmentStatus::Cancelled,
    ]);
}
}
