<?php

namespace App\Models;

use App\Enums\ProgramJenis;
use App\Enums\ProgramStatus;
use Database\Factories\ProgramKerjasamaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Program (PKL, magang, pelatihan, dll) yang berada di dalam satu MoU.
 */
#[Fillable([
    'mou_id',
    'nama_program',
    'jenis',
    'deskripsi',
    'tanggal_mulai',
    'tanggal_selesai',
    'kuota',
    'status',
])]
class ProgramKerjasama extends Model
{
    /** @use HasFactory<ProgramKerjasamaFactory> */
    use HasFactory;

    /**
     * Nama tabel program kerjasama.
     *
     * @var string
     */
    protected $table = 'program_kerjasama';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'jenis' => ProgramJenis::class,
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'kuota' => 'integer',
            'status' => ProgramStatus::class,
        ];
    }

    /**
     * MoU induk program ini.
     *
     * @return BelongsTo<Mou, $this>
     */
    public function mou(): BelongsTo
    {
        return $this->belongsTo(Mou::class);
    }

    /**
     * Lowongan rekrutmen yang berasal dari program ini.
     *
     * @return HasMany<Rekrutmen, $this>
     */
    public function rekrutmen(): HasMany
    {
        return $this->hasMany(Rekrutmen::class);
    }
}
