<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Dokumen pendukung (polymorphic) untuk MoU, perusahaan, atau rekrutmen.
 */
#[Fillable([
    'dokumentable_type',
    'dokumentable_id',
    'nama_dokumen',
    'file_path',
    'tipe_file',
    'file_size',
    'uploaded_by',
])]
class Dokumen extends Model
{
    /**
     * Nama tabel dokumen.
     *
     * @var string
     */
    protected $table = 'dokumen';

    /**
     * Model yang menaungi dokumen ini (MoU / Perusahaan / Rekrutmen).
     *
     * @return MorphTo<Dokumen, $this>
     */
    public function dokumentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * User yang mengunggah dokumen.
     *
     * @return BelongsTo<User, $this>
     */
    public function pengunggah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
