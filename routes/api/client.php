<?php

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\FavoriteController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1/clients')->group(function () {

    Route::post('/register', [ClientController::class,'create']);

    Route::middleware(['jwt'])->group(function(){
        /** CLIENTES */
        Route::get('/{clientId}/profile', [ClientController::class, 'profile'])
            ->name('profile');
        Route::patch('/{clientId}', [ClientController::class, 'edit']);
        Route::delete('/{clientId}', [ClientController::class, 'delete']);

        /** FAVORITOS */
        Route::get('/{clientId}/favorites', [FavoriteController::class, 'list'])
            ->name('favoriteList');
        Route::post('/{clientId}/favorites/{productId}', [FavoriteController::class, 'add']);
        Route::delete('/{clientId}/favorites/{productId}', [FavoriteController::class, 'remove']);
    });
});


