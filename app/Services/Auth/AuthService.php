<?php

namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepository;


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

}



