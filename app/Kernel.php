protected $routeMiddleware = [
    'admin' => \App\Http\Middleware\CheckAdminRole::class,
];