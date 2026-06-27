<?php

namespace Tests\Feature;

use App\Models\Scenario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScenarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_scenarios()
    {
        $user = User::factory()->create();

        Scenario::factory()->count(3)->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/scenarios');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_single_scenario()
    {
        $user = User::factory()->create();

        $scenario = Scenario::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/scenarios/' . $scenario->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $scenario->id);
    }
}