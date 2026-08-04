<?php

use App\Http\Middleware\CheckIfActive;
use App\Http\Middleware\EnsureBillerSetup;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
          $middleware->trustProxies(at: '*');

        // 2. MODERN METHOD: Exclude your Safaricom Webhook from CSRF protection
        $middleware->preventRequestForgery(except: [
            'api/mpesa/callback',
        ]);
        
        $middleware->alias([
            'superuser' => \App\Http\Middleware\CheckRole::class,
            'active' => \App\Http\Middleware\CheckIfActive::class,
            'biller' => \App\Http\Middleware\EnsureBillerSetup::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*'),
        );
    })->create();
