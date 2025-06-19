<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\AddClientFavoritesRequest;
use App\Http\Requests\Client\ListClientFavoritesRequest;
use App\Http\Requests\Client\RemoveClientFavorites;
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
            $created = $this->favoriteService->addFavorite($requestData->getProductId());

            if ($created) return Response::success('Added to favorited', 201);

            return Response::success('Already favorited');

        } catch (\Exception $error) {
            return Response::error($error);
        }
    }

    public function remove(RemoveClientFavorites $requestData)
    {
        try {
            $this->favoriteService->removeFavorite($requestData->getProductId());
            return Response::success(null,204);
        } catch(\Exception $error) {
            return Response::error($error);
        }
    }
}


