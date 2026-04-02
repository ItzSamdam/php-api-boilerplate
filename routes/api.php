<?php
use Controllers\UserController;
use Controllers\ProductController;
use Controllers\DefaultController;
use Middleware\AuthMiddleware;


$routerPath = '/api/v1';

// Default routes
$router->get('/', [DefaultController::class, 'index']);
$router->get($routerPath, [DefaultController::class, 'index']);

// Resource routes
registerResourceRoutes($router, $routerPath . '/users', UserController::class, [AuthMiddleware::class]);
registerResourceRoutes($router, $routerPath . '/products', ProductController::class, [AuthMiddleware::class]);

// Authentication routes (special cases)
$router->post($routerPath . '/login', [UserController::class, 'login']);
$router->post($routerPath . '/register', [UserController::class, 'register']);

// use Controllers\UserController;
// use Controllers\ProductController;
// use Controllers\DefaultController;
// use Middleware\AuthMiddleware;

// $routerPath = '/api/v1';

// $router->get('/', [DefaultController::class, 'index']);
// $router->get($routerPath, [DefaultController::class, 'index']);

// // User routes
// $router->get($routerPath.'/users', [UserController::class, 'index']);
// $router->get('/api/v1/users/{id}', [UserController::class, 'show']);
// $router->post('/api/v1/users', [UserController::class, 'store']);
// $router->put('/api/v1/users/{id}', [UserController::class, 'update'], [AuthMiddleware::class]);
// $router->delete('/api/v1/users/{id}', [UserController::class, 'destroy'], [AuthMiddleware::class]);

// // Product routes
// $router->get('/api/v1/products', [ProductController::class, 'index']);
// $router->get('/api/v1/products/{id}', [ProductController::class, 'show']);
// $router->post('/api/v1/products', [ProductController::class, 'store'], [AuthMiddleware::class]);
// $router->put('/api/v1/products/{id}', [ProductController::class, 'update'], [AuthMiddleware::class]);
// $router->delete('/api/v1/products/{id}', [ProductController::class, 'destroy'], [AuthMiddleware::class]);

// // Authentication routes
// $router->post('/api/v1/login', [UserController::class, 'login']);
// $router->post('/api/v1/register', [UserController::class, 'register']);
