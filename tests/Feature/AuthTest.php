<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase; // каждый тест будет начинаться с чистой базы

    protected string $registerUrl = '/api/auth/register';
    protected string $loginUrl = '/api/auth/login';
    protected string $logoutUrl = '/api/auth/logout';

    public function test_successful_register_returns_token(): void
    {
        $response = $this->postJson($this->registerUrl, [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['access_token', 'token_type']);
    }

    public function test_register_with_existing_email_fails(): void
    {
        User::factory()->create(['email' => 'test@example.com']);

        $response = $this->postJson($this->registerUrl, [
            'name' => 'Another User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'

        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_successful_login_returns_token(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson($this->loginUrl, [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type']);
    }
    public function test_login_with_wrong_password_fails(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('correct_password'),
        ]);

        $response = $this->postJson($this->loginUrl, [
            'email' => 'test@example.com',
            'password' => 'wrong_password'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
    public function test_login_with_non_existing_email_fails(): void
    {
        $response = $this->postJson($this->loginUrl, [
            'email' => 'unknown@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
    public function test_me_returns_user_data(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->getJson('/api/auth/me', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }
    public function test_logout_revokes_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out']);
    }

}
