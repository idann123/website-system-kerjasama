<?php

namespace App\Enums;

enum RekrutmenStatus: string
{
    case Open = 'open';

    case Closed = 'closed';

    case Filled = 'filled';

    /**
     * Label human-readable untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Open => 'Dibuka',
            self::Closed => 'Ditutup',
            self::Filled => 'Terisi',
        };
    }
}
