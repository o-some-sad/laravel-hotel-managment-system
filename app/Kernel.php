protected $routeMiddleware = [
    'admin' => \App\Http\Middleware\CheckAdminRole::class,
    'receptionist' => \App\Http\Middleware\CheckReceptionistRole::class,
];