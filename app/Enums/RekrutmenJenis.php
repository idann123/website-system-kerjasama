<?php

namespace App\Enums;

enum RekrutmenJenis: string
{
    case Fulltime = 'fulltime';

    case Parttime = 'parttime';

    case Kontrak = 'kontrak';

    case Magang = 'magang';

    /**
     * Label human-readable untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Fulltime => 'Full Time',
            self::Parttime => 'Part Time',
            self::Kontrak => 'Kontrak',
            self::Magang => 'Magang',
        };
    }
}
