<?php

namespace Tests\Feature;

use App\Enums\PerusahaanStatus;
use App\Models\Mou;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PerusahaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_index(): void
    {
        $this->get(route('perusahaan.index'))->assertRedirect(route('login'));
    }

    public function test_industri_cannot_access_index(): void
    {
        $industri = User::factory()->industri()->create();

        $this->actingAs($industri)->get(route('perusahaan.index'))->assertForbidden();
    }

    public function test_admin_and_staff_can_access_index(): void
    {
        foreach (['admin', 'staff'] as $role) {
            $user = User::factory()->{$role}()->create();
            Perusahaan::factory()->create();
            $this->actingAs($user)->get(route('perusahaan.index'))
                ->assertOk()
                ->assertSee('Manajemen Perusahaan Mitra');
        }
    }

    public function test_create_page_loads(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('perusahaan.create'))->assertOk();
    }

    public function test_store_validates_required_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('perusahaan.store'), [])
            ->assertSessionHasErrors(['nama_perusahaan', 'bidang_usaha', 'alamat', 'kota', 'provinsi', 'nama_pic', 'telepon_pic', 'email_pic', 'status']);
    }

    public function test_store_persists_company(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('perusahaan.store'), [
            'nama_perusahaan' => 'PT Contoh Mitra',
            'bidang_usaha' => 'Teknologi Informasi',
            'alamat' => 'Jl. Contoh No. 1',
            'kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'nama_pic' => 'Budi',
            'telepon_pic' => '081234567890',
            'email_pic' => 'budi@contoh.co.id',
            'status' => PerusahaanStatus::Aktif->value,
        ]);

        $response->assertRedirect(route('perusahaan.index'));
        $this->assertDatabaseHas('perusahaan', ['nama_perusahaan' => 'PT Contoh Mitra']);
    }

    public function test_store_with_logo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('perusahaan.store'), [
            'nama_perusahaan' => 'PT Logo',
            'bidang_usaha' => 'Manufaktur',
            'alamat' => 'Jl. Logo',
            'kota' => 'Jakarta',
            'provinsi' => 'DKI Jakarta',
            'nama_pic' => 'Ani',
            'telepon_pic' => '0811111111',
            'email_pic' => 'ani@logo.co.id',
            'status' => PerusahaanStatus::Aktif->value,
            'logo' => UploadedFile::fake()->image('logo.png'),
        ])->assertRedirect();

        $company = Perusahaan::where('nama_perusahaan', 'PT Logo')->first();
        $this->assertNotNull($company->logo);
        Storage::disk('public')->assertExists($company->logo);
    }

    public function test_show_displays_company(): void
    {
        $admin = User::factory()->admin()->create();
        $company = Perusahaan::factory()->create();

        $this->actingAs($admin)->get(route('perusahaan.show', $company))
            ->assertOk()
            ->assertSee($company->nama_perusahaan);
    }

    public function test_edit_page_loads(): void
    {
        $admin = User::factory()->admin()->create();
        $company = Perusahaan::factory()->create();

        $this->actingAs($admin)->get(route('perusahaan.edit', $company))->assertOk();
    }

    public function test_update_changes_data(): void
    {
        $admin = User::factory()->admin()->create();
        $company = Perusahaan::factory()->create();

        $this->actingAs($admin)->patch(route('perusahaan.update', $company), [
            'nama_perusahaan' => 'Perusahaan Diubah',
            'bidang_usaha' => $company->bidang_usaha,
            'alamat' => $company->alamat,
            'kota' => $company->kota,
            'provinsi' => $company->provinsi,
            'nama_pic' => $company->nama_pic,
            'telepon_pic' => $company->telepon_pic,
            'email_pic' => $company->email_pic,
            'status' => PerusahaanStatus::NonAktif->value,
        ])->assertRedirect(route('perusahaan.show', $company));

        $company->refresh();
        $this->assertSame('Perusahaan Diubah', $company->nama_perusahaan);
        $this->assertSame(PerusahaanStatus::NonAktif, $company->status);
    }

    public function test_status_endpoint_updates_status(): void
    {
        $admin = User::factory()->admin()->create();
        $company = Perusahaan::factory()->create();

        $this->actingAs($admin)->patch(route('perusahaan.status', $company), [
            'status' => PerusahaanStatus::NonAktif->value,
        ])->assertRedirect();

        $this->assertSame(PerusahaanStatus::NonAktif, $company->fresh()->status);
    }

    public function test_destroy_blocked_when_has_mou(): void
    {
        $admin = User::factory()->admin()->create();
        $company = Perusahaan::factory()->create();
        $staff = User::factory()->staff()->create();
        Mou::factory()->create(['perusahaan_id' => $company->id, 'created_by' => $staff->id]);

        $this->actingAs($admin)->delete(route('perusahaan.destroy', $company))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('perusahaan', ['id' => $company->id]);
    }

    public function test_destroy_succeeds_without_mou(): void
    {
        $admin = User::factory()->admin()->create();
        $company = Perusahaan::factory()->create();

        $this->actingAs($admin)->delete(route('perusahaan.destroy', $company))
            ->assertRedirect(route('perusahaan.index'));

        $this->assertDatabaseMissing('perusahaan', ['id' => $company->id]);
    }
}
