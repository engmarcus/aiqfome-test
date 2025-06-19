<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\AddClientFavoritesRequest;
use App\Http\Requests\Client\ListClientFavoritesRequest;
use App\Services\Client\FavoriteService;
use App\Support\Helpers\Response;

class FavoriteController extends Controller
{
    private $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function list(ListClientFavoritesRequest $requestData)
    {
        $client = $requestData->user();

        try {
            $favorites = $this->favoriteService->listAll($client->id);

            if ($favorites->isEmpty()) {
                return Response::success(null,204);
            }

            return Response::success($favorites);

        } catch(\Exception $error) {
            return Response::error($error);
        }
    }

    public function add(AddClientFavoritesRequest $requestData)
    {

        try {
            $this->favoriteService->addFavorite($requestData->getProductId());
            return Response::success(null,204);
        } catch(\Exception $error) {
            return Response::error($error);
        }
    }

    public function remove(int $clientId)
    {
        try {
            return [];
        } catch(\Exception $e) {
            return [];
        }
    }
}


