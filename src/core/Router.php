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
        $parsedUrl = parse_url($path);
        $params = [];
        $requestData = [];

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $params);
        }

        if ($method == 'POST') {
            $jsonData = file_get_contents('php://input');
            $requestData = json_decode($jsonData, true);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: http://localhost:5173');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            http_response_code(200); // Respond with OK status for preflight request
            exit;
        }

        /* Route without params exists */
        if (isset($this->routes[$method][$parsedUrl['path']])) {
            $callback = $this->routes[$method][$parsedUrl['path']];
            if (is_array($callback)) {
                $callback[0] = new $callback[0];
            }
            // Set header to return JSON response
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header('Access-Control-Allow-Headers: Content-Type');
            call_user_func($callback, $params, $requestData);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header('Access-Control-Allow-Headers: Content-Type');
            echo json_encode(array("message" => "Not Found"));
        }
    }
}

// Check if route exists for the given method and path