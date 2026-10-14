<?php

namespace App\Models;

use App\Enums\LogAksi;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Audit trail aktivitas penting dalam sistem.
 */
#[Fillable([
    'user_id',
    'aksi',
    'model_type',
    'model_id',
    'data_lama',
    'data_baru',
    'ip_address',
])]
class LogAktivitas extends Model
{
    /**
     * Nama tabel log aktivitas.
     *
     * @var string
     */
    protected $table = 'log_aktivitas';

    /**
     * Log aktivitas hanya memiliki created_at.
     */
    public const UPDATED_AT = null;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'aksi' => LogAksi::class,
            'data_lama' => 'array',
            'data_baru' => 'array',
        ];
    }

    /**
     * User yang melakukan aksi.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Model yang menjadi objek aksi.
     *
     * @return MorphTo<LogAktivitas, $this>
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
