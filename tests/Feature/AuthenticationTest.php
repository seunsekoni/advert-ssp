<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testValidationDuringRegistration()
    {
        $response = $this->postJson('/api/register');

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function testIfRegistrationSuccessful()
    {
        $payload = [
            'name' => 'Test name',
            'email' => 'seks@rt.h',
            'password' => 'password',
        ];

        $response = $this->postJson('api/register', $payload);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'message',
                    'data'
                ]);
    }

    public function testIfRegisteredUserCanLogin()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $user = $user->toArray();

        $user['password'] = 'password';

        $response = $this->postJson('api/login', $user);

        $response->assertStatus(200)
                    ->assertJsonStructure([
                        'data' => ['token']
                    ]);
    }

    public function testIfANonRegisteredCannotLogin()
    {
        $user = User::factory()->make();

        $user = $user->toArray();

        $user['password'] = 'password';

        $response = $this->postJson('api/login', $user);

        $response->assertStatus(400)
                    ->assertJsonMissingExact([
                        'data' => ['token']
                    ]);
    }
}
