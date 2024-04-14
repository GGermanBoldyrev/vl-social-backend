<?php

namespace src\core;

use src\enums\HttpMethod;
use src\interfaces\RouterInterface;

class Router implements RouterInterface
{
    private array $routes = [];

    public function addRoute(HttpMethod $method, string $path, callable|array $callback): void
    {
        $this->routes[$method->value][$path] = $callback;
    }

    public function route(string $method, string $path): void
    {
        /* Make path without query params */
        $parsedUrl = parse_url($path);
        /* Parse params */
        $params = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $params);
        }
        /* Route without params exists */
        if (isset($this->routes[$method][$parsedUrl['path']])) {
            $callback = $this->routes[$method][$parsedUrl['path']];
            if (is_array($callback)) {
                $callback[0] = new $callback[0];
            }
            // Set header to return JSON response
            header('Content-Type: application/json');
            call_user_func($callback, $params);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(array("message" => "Not Found"));
        }
    }
}

// Check if route exists for the given method and path