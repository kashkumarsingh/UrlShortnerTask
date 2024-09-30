<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //disable csrf
        $middleware->validateCsrfTokens(except: [
            // Exclude the /encode and /decode endpoints
            'encode',    // This is the route name; adjust if you have a specific prefix
            'decode',    // This is the route name; adjust if you have a specific prefix
            // If you have URL patterns, you can also specify them
            'stripe/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
