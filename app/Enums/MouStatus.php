<?php

namespace App\Enums;

enum MouStatus: string
{
    case Draft = 'draft';

    case Review = 'review';

    case Approved = 'approved';

    case Active = 'active';

    case Expired = 'expired';

    case Terminated = 'terminated';

    /**
     * Label human-readable untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Review => 'Review',
            self::Approved => 'Approved',
            self::Active => 'Aktif',
            self::Expired => 'Kedaluwarsa',
            self::Terminated => 'Dihentikan',
        };
    }
}
