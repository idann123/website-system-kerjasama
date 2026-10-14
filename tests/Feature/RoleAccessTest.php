<?php

namespace Tests\Feature;

use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_protected_pages(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/pengguna')->assertRedirect('/login');
        $this->get('/profile')->assertRedirect('/login');
    }

    public function test_admin_can_access_pengguna_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/pengguna')->assertOk();
    }

    public function test_staff_can_not_access_pengguna_page(): void
    {
        $staff = User::factory()->staff()->create();

        $this->actingAs($staff)->get('/pengguna')->assertForbidden();
    }

    public function test_industri_can_not_access_pengguna_page(): void
    {
        $industri = User::factory()->industri()->create();

        $this->actingAs($industri)->get('/pengguna')->assertForbidden();
    }

    public function test_dashboard_is_accessible_for_every_role(): void
    {
        $users = [
            User::factory()->admin()->create(),
            User::factory()->staff()->create(),
            User::factory()->industri()->create(),
        ];

        foreach ($users as $user) {
            $this->actingAs($user)->get('/dashboard')->assertOk();
        }
    }

    public function test_admin_dashboard_shows_statistics(): void
    {
        $admin = User::factory()->admin()->create();
        Perusahaan::factory()->create();

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Perusahaan Mitra')
            ->assertSee('MoU Aktif');
    }

    public function test_industri_dashboard_shows_linked_company(): void
    {
        $perusahaan = Perusahaan::factory()->create();
        $industri = User::factory()->industri()->create(['perusahaan_id' => $perusahaan->id]);

        $this->actingAs($industri)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Perusahaan Anda')
            ->assertSee($perusahaan->nama_perusahaan);
    }

    public function test_registration_route_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [
            'name' => 'Hacker',
            'email' => 'hacker@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertNotFound();
    }

    public function test_login_redirects_to_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
