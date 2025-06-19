<?php

namespace App\Services\Auth;

use App\Data\DTOs\ClientPasswordResetDto;
use Illuminate\Support\Str;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository) {
        $this->authRepository = $authRepository;
    }

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

    public function resetPassword(ClientPasswordResetDto $data): string
    {
        $credentials = [
            'email' => $data->email,
            'password' => $data->password,
        ];

        $client = $this->authRepository->getClientByEmail($data->email);

        if (!$client || !$this->checkCredentials($credentials, $client)) {
            throw new \RuntimeException('Invalid credentials', 401);
        }

        $client->password = Hash::make($data->newPassword);
        $client->remember_token = Str::random(60);

        $client->save();
        return 'Password updated successfully.';
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

    private function checkCredentials(array $credentials, $client): bool
    {
        return Hash::check($credentials['password'], $client->password);
    }

}



