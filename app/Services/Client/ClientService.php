<?php

namespace App\Services\Client;

use App\Http\Requests\Auth\ClientRegisterRequest;
use App\Models\Client;
use App\Repositories\Client\ClientRepository;

class ClientService
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function createClient(ClientRegisterRequest $userData): Client
    {
        return  $this->clientRepository->insert($userData);
    }

}



