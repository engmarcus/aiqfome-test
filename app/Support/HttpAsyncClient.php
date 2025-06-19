<?php
namespace App\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;

abstract class HttpAsyncClient
{
    protected Client $guzzleClient;
    protected string $baseUrl;
    protected array $defaultHeaders = [];

    public function config(string $baseUrl, array $defaultHeaders = [])
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->defaultHeaders = $defaultHeaders;
        $this->guzzleClient = new Client([
            'base_uri' => $this->baseUrl,
            'http_errors' => false,
            'headers' => $this->defaultHeaders,
        ]);
    }

    public function sendAsyncRequest(string $method, string $endpoint, ?array $data = null): PromiseInterface
    {
        $options = [];

        if ($data !== null) {
            if (strtoupper($method) === 'GET') {
                $options['query'] = $data;
            } else {
                $options['json'] = $data;
            }
        }

        return $this->guzzleClient->requestAsync($method, ltrim($endpoint, '/'), $options)
            ->then(function ($response) {
                $body = (string) $response->getBody();
                $decoded = json_decode($body, true);
                return [
                    'statusCode' => $response->getStatusCode(),
                    'data' => $decoded,
                    'message' => null,
                ];
            }, function ($exception) {
                return [
                    'statusCode' => 500,
                    'data' => null,
                    'message' => $exception->getMessage(),
                ];
            });
    }

    public function getAsync(string $endpoint, ?array $query = null): PromiseInterface
    {
        return $this->sendAsyncRequest('GET', $endpoint, $query);
    }

    public function postAsync(string $endpoint, array $data): PromiseInterface
    {
        return $this->sendAsyncRequest('POST', $endpoint, $data);
    }


}
