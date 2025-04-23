<?php
namespace App\Http;

class Kernel
{
    protected $routeMiddleware = [
        'admin' => \App\Http\Middleware\CheckAdminRole::class,
        'receptionist' => \App\Http\Middleware\CheckReceptionistRole::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
    ];
}

