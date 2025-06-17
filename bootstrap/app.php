<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api')
                ->name('users.')
                ->group(base_path('routes/api/users.php'));
            Route::middleware('api')
                ->prefix('api')
                ->name('products.')
                ->group(base_path('routes/api/products.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
