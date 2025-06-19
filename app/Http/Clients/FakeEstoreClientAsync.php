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
    /*public function fetchProductAsync(int $productId): PromiseInterface
    {
        $cacheKey = "products.{$productId}";
        $cached = cache()->get($cacheKey);

        if ($cached) {
            return Create::promiseFor([
                'statusCode' => 200,
                'data' => $cached,
                'message' => null,
            ]);
        }

        $endpoint = $this->buildProductEndpoint($productId);

        return $this->guzzleClient->getAsync($endpoint)
            ->then(function ($response) use ($cacheKey) {
                $body = (string) $response->getBody();
                $data = json_decode($body, true);

                if (!empty($data)) {
                    cache()->put($cacheKey, $data, now()->addMinutes(10));
                }

                return [
                    'statusCode' => $response->getStatusCode(),
                    'data' => $data,
                    'message' => null,
                ];
            }, function ($exception) {
                return [
                    'statusCode' => 500,
                    'data' => null,
                    'message' => $exception->getMessage(),
                ];
            });
    }*/

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
