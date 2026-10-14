<?php

namespace App\Models;

use App\Enums\PerusahaanStatus;
use Database\Factories\PerusahaanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Profil perusahaan/industri yang menjadi mitra kerja sama sekolah.
 */
#[Fillable([
    'nama_perusahaan',
    'bidang_usaha',
    'alamat',
    'kota',
    'provinsi',
    'kode_pos',
    'no_telepon',
    'email',
    'website',
    'nama_pimpinan',
    'nama_pic',
    'telepon_pic',
    'email_pic',
    'deskripsi',
    'logo',
    'status',
])]
class Perusahaan extends Model
{
    /** @use HasFactory<PerusahaanFactory> */
    use HasFactory;

    /**
     * Nama tabel (bentuk jamak bawaan Eloquent tidak berlaku untuk "perusahaan").
     *
     * @var string
     */
    protected $table = 'perusahaan';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PerusahaanStatus::class,
        ];
    }

    /**
     * Semua MoU yang dimiliki perusahaan ini.
     *
     * @return HasMany<Mou, $this>
     */
    public function mous(): HasMany
    {
        return $this->hasMany(Mou::class);
    }

    /**
     * Akun pengguna (role industri) yang terhubung ke perusahaan ini.
     *
     * @return HasMany<User, $this>
     */
    public function pengguna(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Lowongan rekrutmen yang berasal dari perusahaan ini.
     *
     * @return HasMany<Rekrutmen, $this>
     */
    public function rekrutmen(): HasMany
    {
        return $this->hasMany(Rekrutmen::class);
    }
}
