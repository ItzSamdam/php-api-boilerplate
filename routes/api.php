<?php

/*
 * Copyright © 2025 Samuel Owadayo. All rights reserved.
 */

use Controllers\UserController;
use Controllers\ProductController;
use Controllers\DefaultController;
use Middleware\AuthMiddleware;
use Utils\Response;


$routerPath = '/api/v1';

// Default routes
$router->get('/', [DefaultController::class, 'index']);
$router->get($routerPath, [DefaultController::class, 'index']);

// Resource routes
registerResourceRoutes($router, "{$routerPath}/users", UserController::class, [AuthMiddleware::class]);
registerResourceRoutes($router, "{$routerPath}/products", ProductController::class, [AuthMiddleware::class]);

// Authentication routes (special cases)
$router->post("{$routerPath}/login", [UserController::class, 'login']);
$router->post("{$routerPath}/register", [UserController::class, 'register']);


// At the very bottom of your route file
$router->setNotFoundHandler(
    fn($request) => Response::notFound("The requested endpoint/resource does not exist")
);

$router->setErrorHandler(
    fn($exception, $request) => Response::serverError("Unexpected server error: " . $exception->getMessage())
);

