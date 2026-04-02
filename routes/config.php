<?php


function registerResourceRoutes($router, $basePath, $controller, $middlewares = []) {
    $router->get($basePath, [$controller, 'index']);
    $router->get($basePath.'/{id}', [$controller, 'show']);
    $router->post($basePath, [$controller, 'store'], $middlewares);
    $router->put($basePath.'/{id}', [$controller, 'update'], $middlewares);
    $router->delete($basePath.'/{id}', [$controller, 'destroy'], $middlewares);
}