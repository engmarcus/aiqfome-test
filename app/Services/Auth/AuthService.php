<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\ClientRegisterRequest;
use App\Models\Client;
use App\Repositories\Client\ClientRepository;

class AuthService
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository) {
        $this->clientRepository = $clientRepository;
    }

    public function createClient(ClientRegisterRequest $userData): Client
    {
        return  $this->clientRepository->insert($userData);
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

}



