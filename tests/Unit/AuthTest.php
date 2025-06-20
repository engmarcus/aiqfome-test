<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\SkipsIfNotTestingEnvironment;

class AuthTest extends TestCase
{
    use DatabaseTransactions;
    use SkipsIfNotTestingEnvironment;

    public function test_user_can_login_with_valid_credentials()
    {
        Client::create([
            'name' => 'teste',
            'email' => 'user@example.com',
            'password' => bcrypt('secret123'),
        ]);

        // Enviar POST para login
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'user@example.com',
            'password' => 'secret123',
        ]);
        // Valida status HTTP 200
        $response->assertStatus(200);

        // Valida JSON com estrutura exata
        $response->assertJson([
            'success' => true,
            'message' => 'ok',
            'data' => [
                'tokenType' => 'Bearer',
                'expiresIn' => 3600,
            ],
        ]);

        $this->assertIsString($response->json('data.token'));
        $this->assertNotEmpty($response->json('data.token'));

    }

    public function test_user_cannot_login_with_invalid_password()
    {
        Client::create([
            'name' => 'teste1',
            'email' => 'user1@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('api/v1/auth/login', [
            'email' => 'user1@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }
}
