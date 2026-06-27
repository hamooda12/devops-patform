<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Scenario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_submission()
    {
        $scenario = Scenario::factory()->create([
    'title' => 'Initialize Git Repository',
    'slug' => 'git-init',
    'type' => 'git',
    'difficulty' => 'easy',
    'points' => 10,
]);
        $response = $this->postJson('/api/submissions', [
            'scenario_id' => $scenario->id,
            'command_output' => 'git init',
        ]);

        $response->assertStatus(401);
    }

   public function test_user_can_create_submission()
{
    $user = User::factory()->create();

    $scenario = Scenario::factory()->gitInit()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/submissions', [
            'scenario_id' => $scenario->id,
            'command_output' => "git init\n git add .\n git commit -m 'initial commit'",
        ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'data',
        ]);
}

    public function test_invalid_scenario_id_returns_validation_error()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/submissions', [
                'scenario_id' => 999,
                'command_output' => 'git init',
            ]);

        $response->assertStatus(422);
    }
}