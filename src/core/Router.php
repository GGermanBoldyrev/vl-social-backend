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
        if (isset($this->routes[$method][$path])) {
            $callback = $this->routes[$method][$path];
            if (is_array($callback)) {
                $callback[0] = new $callback[0];
            }
            call_user_func($callback);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(array("message" => "Not Found"));
        }
    }
}