<?php

use App\Http\Controllers\Client\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt'])->prefix('v1/clients')->group(function () {
    Route::get('/{clientId}/favorites', [FavoriteController::class, 'list']);
    Route::post('/{clientId}/favorites/{productId}', [FavoriteController::class, 'add']);
    Route::delete('/{clientId}/favorites{productId}', [FavoriteController::class, 'remove']);
});
