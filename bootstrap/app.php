<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/
$app = new Application(
    basePath: dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
*/
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    Illuminate\Foundation\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Illuminate\Foundation\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Illuminate\Foundation\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware Aliases
|--------------------------------------------------------------------------
| Customize HTTP middleware and alias third‑party packages here.
*/
$app = $app->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role'               => RoleMiddleware::class,
        'permission'         => PermissionMiddleware::class,
        'role_or_permission' => RoleOrPermissionMiddleware::class,
    ]);
});

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
*/
$app = $app->withRoutes(function (Router $router) {
    $router->group([
        'middleware' => ['web'],
        'namespace'  => 'App\Http\Controllers',
    ], function () {
        require __DIR__.'/../routes/web.php';
    });

    $router->group([
        'middleware' => ['api'],
        'prefix'     => 'api',
        'namespace'  => 'App\Http\Controllers',
    ], function () {
        require __DIR__.'/../routes/api.php';
    });
});

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
*/
return tap($app, function (Application $app) use ($request = Request::capture()) {
    $app->make(Illuminate\Contracts\Http\Kernel::class)->handle($request);
});
