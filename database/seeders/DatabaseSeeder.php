<?php

namespace Database\Seeders;

use App\Models\Mou;
use App\Models\Perusahaan;
use App\Models\ProgramKerjasama;
use App\Models\Rekrutmen;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Semua akun demo memakai password: "password"
     */
    public function run(): void
    {
        $perusahaan = Perusahaan::factory()->count(3)->create();

        User::factory()->admin()->create([
            'name' => 'Kepala BKK',
            'email' => 'admin@smkkosgoro.sch.id',
        ]);

        $staff = User::factory()->staff()->create([
            'name' => 'Staff Hubinas',
            'email' => 'staff@smkkosgoro.sch.id',
        ]);

        User::factory()->industri()->create([
            'name' => 'PIC Mitra Industri',
            'email' => 'industri@contoh.co.id',
            'perusahaan_id' => $perusahaan->first()->id,
        ]);

        Mou::factory()->count(3)
            ->state([
                'perusahaan_id' => fn () => $perusahaan->random()->id,
                'created_by' => $staff->id,
            ])
            ->create()
            ->each(function (Mou $mou): void {
                ProgramKerjasama::factory()->count(2)
                    ->state(['mou_id' => $mou->id])
                    ->create();
            });

        $programs = ProgramKerjasama::query()->pluck('id');

        Rekrutmen::factory()->count(3)
            ->state([
                'program_kerjasama_id' => fn () => $programs->random(),
                'perusahaan_id' => fn () => $perusahaan->random()->id,
            ])
            ->create();
    }
}
