<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible(): void
    {
        $this->get('/')->assertOk();
        $this->get('/testimoni')->assertOk();
        $this->get('/berita')->assertOk();
        $this->get('/mitra')->assertOk();
    }

    public function test_login_page_shows_indonesian_copy(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Masuk ke akun Anda')
            ->assertSee('Lupa password?');
    }

    public function test_public_navbar_shows_login_button_for_guests(): void
    {
        $this->get('/')->assertSee('Masuk', false);
    }
}
