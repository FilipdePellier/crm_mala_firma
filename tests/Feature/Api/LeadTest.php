<?php

namespace Tests\Feature\Api;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_indeks_zwraca_liste_leadow()
    {
        Lead::factory()->count(5)->create();
        $response = $this->getJson('/api/leady');
        $response->assertStatus(200)->assertJsonCount(5, 'data');
    }

    public function test_store_tworzy_nowy_lead()
    {
        $data = Lead::factory()->make()->toArray();
        $response = $this->postJson('/api/leady', $data);
        $response->assertStatus(201)->assertJsonFragment(['email' => $data['email']]);
        $this->assertDatabaseHas('Leady', ['email' => $data['email']]);
    }

    public function test_update_modyfikuje_leada()
    {
        $lead = Lead::factory()->create();
        $updateData = ['status' => 'Skwalifikowany'];
        $response = $this->putJson('/api/leady/' . $lead->id_leada, $updateData);
        $response->assertStatus(200)->assertJsonFragment(['status' => 'Skwalifikowany']);
        $this->assertDatabaseHas('Leady', ['id_leada' => $lead->id_leada, 'status' => 'Skwalifikowany']);
    }

    public function test_destroy_usuwa_leada()
    {
        $lead = Lead::factory()->create();
        $response = $this->deleteJson('/api/leady/' . $lead->id_leada);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('Leady', ['id_leada' => $lead->id_leada]);
    }
}