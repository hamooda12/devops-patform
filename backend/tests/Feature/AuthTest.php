<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase


{use RefreshDatabase;
    public function test_user_can_register()
{
    $response = $this->postJson('/api/register', [
        'name' => 'Hamad',
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(201)
    ->assertJsonStructure([
        'message',
        'user' => [
            'id',
            'name',
            'email',
            'role',
            'created_at',
        ],
    ]);
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
}
public function test_user_can_login()
{
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'name',
                'email',
                'role',
                'created_at',
            ],
            'token',
        ]);
}
}
