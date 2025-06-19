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
        $endPoint = $this->buildProductEndpoint($productId);
        return $this->get($endPoint);
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
