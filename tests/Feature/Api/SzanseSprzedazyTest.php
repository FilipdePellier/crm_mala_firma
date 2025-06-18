<?php

namespace Tests\Feature\Api;

use App\Models\SzanseSprzedazy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SzanseSprzedazyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_indeks_zwraca_szanse_sprzedazy()
    {
        SzanseSprzedazy::factory()->count(3)->create();
        $response = $this->getJson('/api/szanse-sprzedazy');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    public function test_store_tworzy_nowa_szanse()
    {
        $data = SzanseSprzedazy::factory()->make()->toArray();
        $response = $this->postJson('/api/szanse-sprzedazy', $data);
        $response->assertStatus(201)->assertJsonFragment(['nazwa' => $data['nazwa']]);
        $this->assertDatabaseHas('SzanseSprzedazy', ['nazwa' => $data['nazwa']]);
    }

    public function test_update_modyfikuje_szanse()
    {
        $szansa = SzanseSprzedazy::factory()->create();
        $updateData = ['etap' => 'Negocjacje'];
        $response = $this->putJson('/api/szanse-sprzedazy/' . $szansa->id_szansy, $updateData);
        $response->assertStatus(200)->assertJsonFragment(['etap' => 'Negocjacje']);
        $this->assertDatabaseHas('SzanseSprzedazy', ['id_szansy' => $szansa->id_szansy, 'etap' => 'Negocjacje']);
    }
}