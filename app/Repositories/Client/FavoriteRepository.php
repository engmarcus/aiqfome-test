<?php

namespace App\Repositories\Client;

use App\Models\FavoriteProduct;

class FavoriteRepository
{

    public function getByClientId(int $clientId)
    {
        return FavoriteProduct::where('client_id',$clientId)->get();
    }
}



