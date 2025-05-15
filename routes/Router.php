/**
* routes/Router.php - Handle routing
*/


<?php

namespace Routes;

use Utils\Request;
use Utils\Response;

class Router
{
    private $request;
    private $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
        'PATCH' => []
    ];
    private $middlewares = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback, $middlewares = [])
    {
        $this->addRoute('GET', $path, $callback, $middlewares);
        return $this;
    }

    public function post($path, $callback, $middlewares = [])
    {
        $this->addRoute('POST', $path, $callback, $middlewares);
        return $this;
    }

    public function put($path, $callback, $middlewares = [])
    {
        $this->addRoute('PUT', $path, $callback, $middlewares);
        return $this;
    }

    public function delete($path, $callback, $middlewares = [])
    {
        $this->addRoute('DELETE', $path, $callback, $middlewares);
        return $this;
    }

    public function patch($path, $callback, $middlewares = [])
    {
        $this->addRoute('PATCH', $path, $callback, $middlewares);
        return $this;
    }

    private function addRoute($method, $path, $callback, $middlewares)
    {
        // Convert path to regex for parameter matching
        $pathRegex = preg_replace('/\/{([^\/]+)}/', '/(?P<$1>[^/]+)', $path);
        $pathRegex = '@^' . $pathRegex . '$@';

        $this->routes[$method][$pathRegex] = [
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    public function resolve()
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();

        // Check if route exists
        if (!isset($this->routes[$method])) {
            return Response::notFound("Route method not supported");
        }

        $routeFound = false;
        $params = [];

        foreach ($this->routes[$method] as $routeRegex => $route) {
            if (preg_match($routeRegex, $path, $matches)) {
                $routeFound = true;

                // Extract named parameters
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }

                // Run middlewares
                foreach ($route['middlewares'] as $middleware) {
                    $instance = new $middleware();
                    $instance->handle($this->request);
                }

                // Call route callback
                $callback = $route['callback'];

                if (is_array($callback)) {
                    [$controller, $method] = $callback;

                    if (is_string($controller)) {
                        $controller = new $controller();
                    }

                    $response = $controller->{$method}($this->request, $params);
                    return $response;
                }

                if (is_callable($callback)) {
                    $response = call_user_func($callback, $this->request, $params);
                    return $response;
                }

                break;
            }
        }

        if (!$routeFound) {
            return Response::notFound("Route not found");
        }
    }
}
