<?php

namespace App\Models;

use App\Enums\MouStatus;
use Database\Factories\MouFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Memorandum of Understanding antara sekolah dan perusahaan mitra.
 */
#[Fillable([
    'nomor_mou',
    'perusahaan_id',
    'created_by',
    'judul',
    'deskripsi',
    'tanggal_mulai',
    'tanggal_berakhir',
    'status',
    'dokumen_path',
    'catatan',
    'approved_at',
    'approved_by',
])]
class Mou extends Model
{
    /** @use HasFactory<MouFactory> */
    use HasFactory;

    /**
     * Nama tabel MoU.
     *
     * @var string
     */
    protected $table = 'mou';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_berakhir' => 'date',
            'status' => MouStatus::class,
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Perusahaan mitra pemilik MoU.
     *
     * @return BelongsTo<Perusahaan, $this>
     */
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }

    /**
     * User yang membuat MoU.
     *
     * @return BelongsTo<User, $this>
     */
    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * User yang menyetujui MoU.
     *
     * @return BelongsTo<User, $this>
     */
    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Program kerjasama yang berada di bawah MoU ini.
     *
     * @return HasMany<ProgramKerjasama, $this>
     */
    public function programs(): HasMany
    {
        return $this->hasMany(ProgramKerjasama::class);
    }
}
