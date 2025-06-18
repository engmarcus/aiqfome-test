<?php

namespace App\Services\Client;

use App\Http\Clients\FakeEstoreClient;
use App\Repositories\Client\FavoriteRepository;

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

    public function addFavorite()
    {
        $this->fakeEstoreClient->fetchProduct(1);
    }
}



