<?php

use App\Http\Controllers\Products\ProductController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1/products')->group(function () {
    Route::get('/', [ProductController::class,'listAll']);
});
