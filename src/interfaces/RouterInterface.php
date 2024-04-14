<?php

namespace src\interfaces;

use src\enums\HttpMethod;

interface RouterInterface
{
    public function addRoute(HttpMethod $method, string $path, callable | array $callback): void;
    public function route(string $method, string $path): void;
}