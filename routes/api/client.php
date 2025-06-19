<?php

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\FavoriteController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1/clients')->group(function () {

    Route::post('/register', [ClientController::class,'create']);

    Route::middleware(['jwt'])->group(function(){
        Route::get('/{clientId}/favorites', [FavoriteController::class, 'list']);
        Route::post('/{clientId}/favorites/{productId}', [FavoriteController::class, 'add']);
        Route::delete('/{clientId}/favorites/{productId}', [FavoriteController::class, 'remove']);
    });
});


