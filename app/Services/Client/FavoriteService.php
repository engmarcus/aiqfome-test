<?php

namespace App\Services\Client;

use App\Data\DTOs\ProductDto;
use App\Data\Mappers\ProductMapper;
use App\Http\Clients\FakeEstoreClientAsync;
use App\Repositories\Client\FavoriteRepository;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FavoriteService
{
    private $favoriteRepository;
    private $fakeEstoreClient;
    public function __construct(FavoriteRepository $favoriteRepository, FakeEstoreClientAsync $fakeEstoreClient)
    {
        $this->favoriteRepository = $favoriteRepository;
        $this->fakeEstoreClient = $fakeEstoreClient;
    }

    public function listAll(int $clientId): Collection
    {
        $favorites = $this->favoriteRepository->getByClientId($clientId);
        if ($favorites->isEmpty()) return collect([]);

        $productIds = $favorites->pluck('product_id')->toArray();
         $responses = $this->resolveInChunks($productIds);
        return $this->mapValidProducts($responses);

    }

    public function addFavorite(int $productId)
    {
        $exists = $this->getProduct($productId);
        if(!$exists){
            throw new NotFoundHttpException("Product not found: ID {$productId}",null,404);
        }

        $clientId = auth()->id();

        $favorite = $this->favoriteRepository->addItem( [
            'client_id'  => $clientId,
            'product_id' => $productId,
        ]);

        return $favorite->wasRecentlyCreated;

    }
    public function removeFavorite(int $productId)
    {
        $clientId = auth()->id();
        $isDeleted = $this->favoriteRepository->removeItem($productId,$clientId);
        if (!$isDeleted) {
            throw new NotFoundHttpException("Favorite not found: ID {$productId}",null,404);
        }
    }


    private function buildProductPromises(array $ids): array
    {
        $promises = [];

        foreach ($ids as $id) {
            $promises[$id] = $this->fakeEstoreClient->fetchProductAsync($id);
        }
        return $promises;
    }

    private function resolveInChunks(array $ids, int $chunkSize = 10): array
    {
        $allResponses = [];

        foreach (array_chunk($ids, $chunkSize) as $chunk) {

            $promises = $this->buildProductPromises($chunk);
            $responses = Utils::settle($promises)->wait();

            $allResponses = array_merge($allResponses, $responses);
            usleep(10 * 1000); // 10ms
        }
        return $allResponses;
    }

    private function mapValidProducts(array $responses): Collection
    {
        $products = [];
        foreach ($responses as $id => $response) {
            if ($response['state'] === 'fulfilled') {
                $data = $response['value']['data'] ?? null;

                 if ($data) {
                    if (is_array($data)) {
                        $products[] = ProductMapper::fromArray($data);
                    } elseif ($data instanceof ProductDto) {
                        $products[] = $data;
                    }
                }
            }
        }
        return collect($products);
    }

    private function getProduct(int $productId): ?ProductDto
    {
        $cacheKey = "products.{$productId}";
        $cacheTtl = now()->addMinutes(10);

        $cachedData = cache()->get($cacheKey);

        if ($cachedData) {
            return ProductMapper::fromArray($cachedData);
        }

        $response = $this->fakeEstoreClient->fetchProductAsync($productId)->wait();

        $data = $response['data'] ?? null;

        if (empty($data)) {
            return null;
        }

        cache()->put($cacheKey, $data, $cacheTtl);

        return ProductMapper::fromArray($data);
    }
}



