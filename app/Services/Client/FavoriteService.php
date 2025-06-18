<?php

namespace App\Services\Client;

use App\Http\Clients\FakeEstoreClient;
use App\Repositories\Client\FavoriteRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FavoriteService
{
    private $favoriteRepository;
    private $fakeEstoreClient;
    public function __construct(FavoriteRepository $favoriteRepository, FakeEstoreClient $fakeEstoreClient)
    {
        $this->favoriteRepository = $favoriteRepository;
        $this->fakeEstoreClient = $fakeEstoreClient;
    }

    public function listAll(int $clientId)
    {
        $favorites  = $this->favoriteRepository->getByClientId($clientId);

        if($favorites ->isEmpty()) return $favorites;



        return [];
    }

    public function addFavorite(int $productId)
    {
        $exists = $this->fakeEstoreClient->fetchProduct($productId);
        if(!$exists){
            throw new NotFoundHttpException("Product not found: ID {$productId}}",null,404);
        }

        $clientId = auth()->id();

        $this->favoriteRepository->addItem( [
            'client_id'  => $clientId,
            'product_id' => $productId,
        ]);

    }
}



