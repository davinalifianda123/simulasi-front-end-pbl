<?php

use App\Http\Middleware\JwtGuest;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\JwtAuthenticate;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
          'jwt.guest' => JwtGuest::class,
          'jwt.auth' => JwtAuthenticate::class,
          'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
