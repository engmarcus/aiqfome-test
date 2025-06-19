<?php

namespace App\Repositories\Auth;

use App\Models\Client;

class AuthRepository
{
    public function getClientByEmail(string $email)
    {
        return Client::where('email', $email)->first();
    }
}



