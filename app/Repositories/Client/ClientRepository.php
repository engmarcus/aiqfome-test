<?php

namespace App\Repositories\Client;

use App\Data\DTOs\ClientEditDto;
use App\Http\Requests\Auth\ClientRegisterRequest;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class ClientRepository
{
    public function insert(ClientRegisterRequest $userData): Client
    {
        return  Client::create([
                    'name'     => $userData->name,
                    'email'    => $userData->email,
                    'password' => Hash::make($userData->password),
                ]);
    }

    public function update(array $userData, int $clientId): Client
    {
        $client = Client::findOrFail($clientId);
        $client->fill($userData);
        $client->save();

        return $client;
    }

    public function delete(int $clientId)
    {
        return Client::where('id',$clientId)
            ->delete() > 0;
    }




}



