<?php

namespace App\Enums;

enum LogAksi: string
{
    case Created = 'created';

    case Updated = 'updated';

    case Deleted = 'deleted';

    case Approved = 'approved';

    case Rejected = 'rejected';

    case StatusChanged = 'status_changed';

    /**
     * Label human-readable untuk ditampilkan di UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::Created => 'Dibuat',
            self::Updated => 'Diubah',
            self::Deleted => 'Dihapus',
            self::Approved => 'Disetujui',
            self::Rejected => 'Ditolak',
            self::StatusChanged => 'Status Diubah',
        };
    }
}
