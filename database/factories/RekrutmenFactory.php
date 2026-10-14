<?php

namespace Database\Factories;

use App\Enums\RekrutmenJenis;
use App\Enums\RekrutmenStatus;
use App\Models\Perusahaan;
use App\Models\ProgramKerjasama;
use App\Models\Rekrutmen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rekrutmen>
 */
class RekrutmenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program_kerjasama_id' => ProgramKerjasama::factory(),
            'perusahaan_id' => Perusahaan::factory(),
            'judul_lowongan' => fake()->jobTitle(),
            'persyaratan' => fake()->paragraphs(3, true),
            'deskripsi_pekerjaan' => fake()->paragraph(),
            'lokasi_kerja' => fake()->city(),
            'jenis_kerja' => fake()->randomElement(RekrutmenJenis::cases()),
            'kuota' => fake()->numberBetween(1, 10),
            'batas_pendaftaran' => fake()->dateTimeBetween('+1 week', '+2 months')->format('Y-m-d'),
            'status' => RekrutmenStatus::Open,
            'link_gform' => fake()->optional()->url(),
        ];
    }
}
