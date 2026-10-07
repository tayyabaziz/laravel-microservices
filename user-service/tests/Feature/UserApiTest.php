<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_be_listed(): void
    {
        User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
        ]);

        $this->getJson('/api/users')
            ->assertOk()
            ->assertJsonFragment(['name' => 'Alice']);
    }

    public function test_user_can_be_created_with_valid_data(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('name', 'Alice')
            ->assertJsonPath('email', 'alice@example.com')
            ->assertJsonMissingPath('password');

        $this->assertDatabaseHas('users', ['email' => 'alice@example.com']);
        $this->assertNotSame('secret123', User::first()->password);
    }

    public function test_user_creation_requires_valid_email(): void
    {
        $this->postJson('/api/users', [
            'name' => 'Alice',
            'email' => 'not-an-email',
            'password' => 'secret123',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
