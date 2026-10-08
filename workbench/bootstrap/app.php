<?php

use WpStarter\Foundation\Application;
use WpStarter\Foundation\Configuration\Exceptions;
use WpStarter\Foundation\Configuration\Middleware;

use function Orchestra\Testbench\default_skeleton_path;

return Application::configure(basePath: $APP_BASE_PATH ?? default_skeleton_path())
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
