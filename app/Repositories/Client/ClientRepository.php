<?php

namespace App\Repositories\Client;

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

}



