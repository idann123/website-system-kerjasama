<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';

    case Staff = 'staff';

    case Industri = 'industri';

    /**
     * Label human-readable untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Staff => 'Staff',
            self::Industri => 'Industri',
        };
    }
}
