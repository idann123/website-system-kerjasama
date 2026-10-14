<?php

namespace App\Models;

use App\Enums\RekrutmenJenis;
use App\Enums\RekrutmenStatus;
use Database\Factories\RekrutmenFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Lowongan rekrutmen dari perusahaan mitra.
 */
#[Fillable([
    'program_kerjasama_id',
    'perusahaan_id',
    'judul_lowongan',
    'persyaratan',
    'deskripsi_pekerjaan',
    'lokasi_kerja',
    'jenis_kerja',
    'kuota',
    'batas_pendaftaran',
    'status',
    'link_gform',
])]
class Rekrutmen extends Model
{
    /** @use HasFactory<RekrutmenFactory> */
    use HasFactory;

    /**
     * Nama tabel rekrutmen.
     *
     * @var string
     */
    protected $table = 'rekrutmen';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'jenis_kerja' => RekrutmenJenis::class,
            'kuota' => 'integer',
            'batas_pendaftaran' => 'date',
            'status' => RekrutmenStatus::class,
        ];
    }

    /**
     * Program kerjasama induk (opsional).
     *
     * @return BelongsTo<ProgramKerjasama, $this>
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramKerjasama::class, 'program_kerjasama_id');
    }

    /**
     * Perusahaan mitra pemilik lowongan.
     *
     * @return BelongsTo<Perusahaan, $this>
     */
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
