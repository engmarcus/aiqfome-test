<?php

namespace App\Services\Client;

use App\Data\DTOs\ClientEditDto;
use App\Http\Requests\Auth\ClientRegisterRequest;
use App\Models\Client;
use App\Repositories\Client\ClientRepository;
use Exception;

class ClientService
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }


    public function getClient()
    {
        $user = auth()->user();
         return [
            'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
            ]
        ];
    }

    public function updatePartial(ClientEditDto $clientData)
    {
        $userId = auth()->id();
        $dataUpdate = $clientData->toArray();
        return  $this->clientRepository->update($dataUpdate,$userId);
    }

    public function createClient(ClientRegisterRequest $userData): Client
    {
        return  $this->clientRepository->insert($userData);
    }

    public function delete()
    {
        $userId = auth()->id();
        $isDeleted = $this->clientRepository->delete( $userId);
        if (!$isDeleted) {
            throw new Exception('Error removing user',500);
        }
    }

}



