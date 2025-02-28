<?php

namespace Src\Middleware;

use CoffeeCode\Router\Router;
use Src\Error\MethodNotAllowedError;

class ValidateRequestMethodMiddleware
{
    public function handle(Router $router): bool
    {
        $reflection = new \ReflectionClass($router);
        $property = $reflection->getProperty("routes");
        $routes = $property->getValue($router);
        $allowedMethods = array_map("strtoupper", array_keys($routes));
        $currentMethod = mb_strtoupper($_SERVER["REQUEST_METHOD"]);
        if (!in_array($currentMethod, $allowedMethods)) {
            throw new MethodNotAllowedError("method '{$currentMethod}' not allowed to this endpoint. Allowed methods: " . implode(", ", $allowedMethods));
        }
        return true;
    }
}