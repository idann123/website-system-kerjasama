<?php

namespace Database\Factories;

use App\Enums\PerusahaanStatus;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perusahaan>
 */
class PerusahaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_perusahaan' => fake()->company(),
            'bidang_usaha' => fake()->randomElement([
                'Manufaktur',
                'Teknologi Informasi',
                'Tekstil',
                'Kuliner',
                'Otomotif',
                'Pertanian',
            ]),
            'alamat' => fake()->address(),
            'kota' => fake()->city(),
            'provinsi' => fake()->randomElement([
                'Jawa Barat',
                'DKI Jakarta',
                'Jawa Tengah',
                'Jawa Timur',
                'Banten',
            ]),
            'kode_pos' => fake()->postcode(),
            'no_telepon' => fake()->numerify('08##########'),
            'email' => fake()->unique()->companyEmail(),
            'website' => fake()->url(),
            'nama_pimpinan' => fake()->name(),
            'nama_pic' => fake()->name(),
            'telepon_pic' => fake()->numerify('08##########'),
            'email_pic' => fake()->unique()->safeEmail(),
            'deskripsi' => fake()->paragraph(),
            'logo' => null,
            'status' => PerusahaanStatus::Aktif,
        ];
    }

    /**
     * Indicate that the company is inactive.
     */
    public function nonAktif(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PerusahaanStatus::NonAktif,
        ]);
    }
}
