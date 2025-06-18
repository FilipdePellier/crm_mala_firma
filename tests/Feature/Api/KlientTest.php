<?php

namespace Tests\Feature\Api;

use App\Models\Klient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KlientTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_indeks_zwraca_liste_klientow()
    {
        Klient::factory()->count(5)->create();
        $response = $this->getJson('/api/klienci');
        $response->assertStatus(200)->assertJsonCount(5, 'data');
    }

    public function test_store_tworzy_nowego_klienta()
    {
        $data = Klient::factory()->make()->toArray();
        $response = $this->postJson('/api/klienci', $data);
        $response->assertStatus(201)->assertJsonFragment(['firma' => $data['nazwa_firmy']]);
        $this->assertDatabaseHas('Klienci', ['email' => $data['email']]);
    }

    public function test_show_zwraca_konkretnego_klienta()
    {
        $klient = Klient::factory()->create();
        $response = $this->getJson('/api/klienci/' . $klient->id_klienta);
        $response->assertStatus(200)->assertJsonFragment(['id' => $klient->id_klienta]);
    }

    public function test_update_modyfikuje_istniejacego_klienta()
    {
        $klient = Klient::factory()->create();
        $updateData = ['nazwa_firmy' => 'Nowa Firma Testowa'];
        $response = $this->putJson('/api/klienci/' . $klient->id_klienta, $updateData);
        $response->assertStatus(200)->assertJsonFragment(['firma' => 'Nowa Firma Testowa']);
        $this->assertDatabaseHas('Klienci', ['id_klienta' => $klient->id_klienta, 'nazwa_firmy' => 'Nowa Firma Testowa']);
    }

    public function test_destroy_usuwa_klienta()
    {
        $klient = Klient::factory()->create();
        $response = $this->deleteJson('/api/klienci/' . $klient->id_klienta);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('Klienci', ['id_klienta' => $klient->id_klienta]);
    }
}