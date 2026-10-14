<?php

namespace App\Enums;

enum PerusahaanStatus: string
{
    case Aktif = 'aktif';

    case NonAktif = 'non-aktif';

    /**
     * Label human-readable untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Aktif => 'Aktif',
            self::NonAktif => 'Non-Aktif',
        };
    }
}
