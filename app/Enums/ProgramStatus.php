<?php

namespace App\Enums;

enum ProgramStatus: string
{
    case Planned = 'planned';

    case Ongoing = 'ongoing';

    case Completed = 'completed';

    case Cancelled = 'cancelled';

    /**
     * Label human-readable untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Planned => 'Terencana',
            self::Ongoing => 'Berjalan',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }
}
