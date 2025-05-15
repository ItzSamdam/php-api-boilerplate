<?php

require_once __DIR__ . '/vendor/autoload.php'; // Load Composer autoload
require_once __DIR__ . '/Middleware/CorsMiddleware.php';
require_once __DIR__ . '/Utils/Request.php';
require_once __DIR__ . '/Routes/Router.php';

use Middleware\CorsMiddleware;
use Utils\Request;
use Routes\Router;

// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load the bootstrap file
require_once __DIR__ . '/bootstrap.php';

// Initialize middleware
$corsMiddleware = new CorsMiddleware();
$corsMiddleware->handle();

// Get the request
$request = new Request();

// Initialize the router
$router = new Router($request);

// Include the routes
require_once __DIR__ . '/routes/api.php';

// Process the request
$router->resolve();
