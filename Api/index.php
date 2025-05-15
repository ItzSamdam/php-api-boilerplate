/**
* index.php - Entry point for the API
*/
<?php
// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load the bootstrap file
require_once __DIR__ . '/bootstrap.php';

// Initialize middleware
$corsMiddleware = new \Api\Middleware\CorsMiddleware();
$corsMiddleware->handle();

// Get the request
$request = new \Api\Utils\Request();

// Initialize the router
$router = new \Api\Routes\Router($request);

// Include the routes
require_once __DIR__ . '/routes/api.php';

// Process the request
$router->resolve();
