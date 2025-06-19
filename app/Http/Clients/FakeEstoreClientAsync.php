<?php

namespace App\Http\Clients;

use App\Support\HttpAsyncClient;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;


class FakeEstoreClientAsync extends HttpAsyncClient
{
    public function __construct() {
        $this->config( config('fakeapi.baseUrl'));
    }

    public function fetchProductAsync(int $productId): PromiseInterface
    {
        $cacheKey = "products.{$productId}";
        $cached = cache()->get($cacheKey);
        $ttl = now()->addMinutes(10);

        if ($cached) {
            return Create::promiseFor([
                'statusCode' => 200,
                'data' => $cached,
                'message' => null,
            ]);
        }

        $endpoint = $this->buildProductEndpoint($productId);

        return $this->getAsync($endpoint)
            ->then(function ($response) use ($cacheKey, $ttl) {
                if (!empty($response['data'])) {
                    cache()->put($cacheKey, $response['data'],$ttl);
                }
                return $response;
            });
    }

    private function buildProductEndpoint(int $productId): string
    {
        return str_replace('{id}', $productId, config('fakeapi.products.get'));
    }
}
