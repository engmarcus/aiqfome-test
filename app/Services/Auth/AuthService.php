<?php

namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository) {}

    public function signIn(array $credentials): array
    {

        $token = auth('api')->attempt($credentials);

        if (!$token) throw new \Exception('Invalid email or password.',401);

        return [
            'token' => $token,
            'tokenType' => 'Bearer',
            'expiresIn' => auth('api')->factory()->getTTL() * 60,
        ];

    }
    public function getAuthenticatedUser(): array
    {
        $user = auth()->user();
        $token = JWTAuth::getToken();
        $payload = JWTAuth::getPayload($token);

        $expirationTimestamp = $payload('exp');
        $issuedAtTimestamp = $payload('iat');

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ?? 'client',
            ],
            'auth' => [
                'type' => 'Bearer',
                'expiresIn' => max($expirationTimestamp - now()->timestamp, 0),
                'expiresAt' => now()->setTimestamp($expirationTimestamp)->toIso8601String(),
                'authenticatedAt' => now()->setTimestamp($issuedAtTimestamp)->toIso8601String(),
            ],
        ];
    }

    public function logout()
    {
        auth()->logout();
    }

}



