<?php

namespace src\interfaces;

use src\enums\HttpMethod;

interface RouterInterface
{
    public function addRoute(HttpMethod $method, string $path, callable $callback): void;
    public function route(HttpMethod $method, string $path): void;
}