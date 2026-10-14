<?php

namespace App\Enums;

enum ProgramJenis: string
{
    case Pkl = 'pkl';

    case Magang = 'magang';

    case Rekrutmen = 'rekrutmen';

    case Pelatihan = 'pelatihan';

    case KunjunganIndustri = 'kunjungan_industri';

    case Lainnya = 'lainnya';

    /**
     * Label human-readable untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pkl => 'PKL',
            self::Magang => 'Magang',
            self::Rekrutmen => 'Rekrutmen',
            self::Pelatihan => 'Pelatihan',
            self::KunjunganIndustri => 'Kunjungan Industri',
            self::Lainnya => 'Lainnya',
        };
    }
}
