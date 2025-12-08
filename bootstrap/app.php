<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckReceptionistRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            // CheckReceptionistRole::class
        ]);

        // Trust all proxies for Render
        $middleware->trustProxies(at: '*');

        $middleware->alias( [
            
         //   'receptionist' => \App\Http\Middleware\CheckReceptionistRole::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'admin' => \App\Http\Middleware\CheckAdminRole::class,
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdminRole::class,
            'manager' => \App\Http\Middleware\CheckManagerRole::class,
            'receptionist' => \App\Http\Middleware\CheckReceptionistRole::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
