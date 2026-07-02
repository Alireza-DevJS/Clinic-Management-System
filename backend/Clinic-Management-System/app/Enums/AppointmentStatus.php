<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'در انتظار',
            self::Confirmed => 'تأیید شده',
            self::Cancelled => 'لغو شده',
        };
    }
}
