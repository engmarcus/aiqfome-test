<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $fillable = ['client_id', 'product_id'];
    protected $table = 'client.favorite_products';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
