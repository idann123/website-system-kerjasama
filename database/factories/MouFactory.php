<?php

namespace Database\Factories;

use App\Enums\MouStatus;
use App\Models\Mou;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mou>
 */
class MouFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mulai = fake()->dateTimeBetween('-1 year', 'now');
        $berakhir = (clone $mulai)->modify('+'.fake()->numberBetween(1, 36).' months');

        return [
            'nomor_mou' => 'MoU/'.fake()->unique()->numberBetween(1, 9999).'/'.fake()->year(),
            'perusahaan_id' => Perusahaan::factory(),
            'created_by' => User::factory(),
            'judul' => fake()->sentence(4),
            'deskripsi' => fake()->paragraph(),
            'tanggal_mulai' => $mulai->format('Y-m-d'),
            'tanggal_berakhir' => $berakhir->format('Y-m-d'),
            'status' => MouStatus::Draft,
            'dokumen_path' => null,
            'catatan' => null,
            'approved_at' => null,
            'approved_by' => null,
        ];
    }

    /**
     * Indicate that the MoU is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => MouStatus::Active,
            'approved_at' => now(),
            'approved_by' => User::factory()->admin(),
        ]);
    }

    /**
     * Indicate that the MoU is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => MouStatus::Expired,
            'tanggal_mulai' => now()->subYears(2)->format('Y-m-d'),
            'tanggal_berakhir' => now()->subYear()->format('Y-m-d'),
        ]);
    }
}
