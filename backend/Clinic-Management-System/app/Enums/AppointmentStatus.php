<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Completed = 'Completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'در انتظار',
            self::Confirmed => 'تأیید شده',
            self::Cancelled => 'لغو شده',
            self::Completed => 'تکمیل شده',
        };
    }
}
