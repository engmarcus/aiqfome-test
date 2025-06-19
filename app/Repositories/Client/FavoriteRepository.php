<?php

namespace App\Repositories\Client;

use App\Models\FavoriteProduct;
use Illuminate\Database\Eloquent\Collection;

class FavoriteRepository
{
    public function getByClientId(int $clientId): Collection
    {
        return FavoriteProduct::where('client_id',$clientId)->get();
    }

    public function removeItem(int $productId, int $clientId): bool
    {
        return FavoriteProduct::where('client_id',$clientId)
                    ->where('product_id',$productId)
                    ->delete() > 0;
    }

    public function addItem(array $attributes): FavoriteProduct
    {
        return FavoriteProduct::firstOrCreate($attributes);

    }
}



