<?php

namespace Database\Factories;

use App\Enums\ProgramJenis;
use App\Enums\ProgramStatus;
use App\Models\Mou;
use App\Models\ProgramKerjasama;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramKerjasama>
 */
class ProgramKerjasamaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mulai = fake()->dateTimeBetween('+1 month', '+6 months');

        return [
            'mou_id' => Mou::factory(),
            'nama_program' => fake()->randomElement([
                'Program PKL Semester Ganjil',
                'Magang Karyawan Junior',
                'Pelatihan Kompetensi Keahlian',
                'Kunjungan Industri Siswa',
            ]),
            'jenis' => fake()->randomElement(ProgramJenis::cases()),
            'deskripsi' => fake()->paragraph(),
            'tanggal_mulai' => $mulai->format('Y-m-d'),
            'tanggal_selesai' => (clone $mulai)->modify('+3 months')->format('Y-m-d'),
            'kuota' => fake()->numberBetween(5, 30),
            'status' => ProgramStatus::Planned,
        ];
    }
}
