<?php

use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        health: '/up',
        then: function () {
            Route::prefix('api')
                ->name('client.')
                ->group(base_path('routes/api/client.php'));
            Route::prefix('api')
                ->name('auth.')
                ->group(base_path('routes/api/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
            'jwt' => ApiAuthMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

    })->create();

