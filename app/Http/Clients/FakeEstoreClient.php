<?php

namespace App\Http\Clients;

use App\Support\HttpClient;


class FakeEstoreClient extends HttpClient
{

    public function __construct() {
        $baseUrl = config('fakeapi.baseUrl');
        $this->config( $baseUrl);
    }

    public function fetchProduct(int $productId)
    {
        $endPoint = config('fakeapi.products.get');
        $endPoint = str_replace('{id}', $productId, $endPoint);

        $cacheKey   = $this->getProductCacheKey($productId);
        $timeCache  = now()->addMinutes(10);
        return cache()->remember($cacheKey,  $timeCache, function () use ($productId) {
            try {
                $endpoint = $this->buildProductEndpoint($productId);
                $response = $this->get($endpoint);
                /** Editar response para econimizar recursos e memoria cache */
                /* refatorar ROTA ADD FAVORITES */
                dd($response );
                return true;
            } catch (\Throwable $e) {
                return false;
            }
        });
    }

    private function buildProductEndpoint(int $productId): string
    {
        return str_replace('{id}', $productId, config('fakeapi.products.get'));
    }

    private function getProductCacheKey(int $productId): string
    {
        return "products.{$productId}";
    }
}
