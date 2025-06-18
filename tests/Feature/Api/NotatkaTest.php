<?php

namespace Tests\Feature\Api;

use App\Models\Klient;
use App\Models\Notatka;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotatkaTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_store_tworzy_nowa_notatke_dla_klienta()
    {
        $klient = Klient::factory()->create();
        $data = [
            'tresc_notatki' => 'To jest ważna notatka testowa.',
            'id_klienta' => $klient->id_klienta,
        ];

        $response = $this->postJson('/api/notatki', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['tresc' => 'To jest ważna notatka testowa.']);
        
        $this->assertDatabaseHas('Notatki', [
            'tresc_notatki' => 'To jest ważna notatka testowa.',
            'id_klienta' => $klient->id_klienta,
            'utworzono_przez' => $this->user->id_uzytkownika,
        ]);
    }

    public function test_autor_moze_usunac_swoja_notatke()
    {
        $notatka = Notatka::factory()->create(['utworzono_przez' => $this->user->id_uzytkownika]);

        $response = $this->deleteJson('/api/notatki/' . $notatka->id_notatki);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('Notatki', ['id_notatki' => $notatka->id_notatki]);
    }

    public function test_inny_uzytkownik_nie_moze_usunac_notatki()
    {
        $innyUser = User::factory()->create();
        $notatka = Notatka::factory()->create(['utworzono_przez' => $innyUser->id_uzytkownika]);
        
        $response = $this->deleteJson('/api/notatki/' . $notatka->id_notatki);

        $response->assertStatus(403); 
    }
}