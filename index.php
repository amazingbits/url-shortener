<?php

use CoffeeCode\Router\Router;
use Src\Error\BadRequestError;
use Src\Error\ForbiddenError;
use Src\Error\InternalServerError;
use Src\Error\MethodNotAllowedError;
use Src\Error\NotFoundError;
use Src\Error\NotImplementedError;
use Src\Error\UnauthorizedError;
use Src\Middleware\ValidateRequestMethodMiddleware;

date_default_timezone_set("America/Sao_Paulo");

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/eloquent.php";
require_once __DIR__ . "/error_handler.php";

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$router = new Router(getenv("BASE_URL"));
$router->namespace("Src\\Controller");

$router->get("/{shortCode}", "APIController:redirectURL", "redirect.url");
$router->post("/shorten-url", "APIController:shortenURL", "short.url", ValidateRequestMethodMiddleware::class);

$router->group("qrcode");
$router->post("/make", "APIController:makeQRCode", "make.qrcode", ValidateRequestMethodMiddleware::class);

$router->dispatch();

if ($router->error()) {
    $statusCode = (int)$router->error();

    throw match ($statusCode) {
        400 => new BadRequestError(),
        401 => new UnauthorizedError(),
        403 => new ForbiddenError(),
        404 => new NotFoundError(),
        405 => new MethodNotAllowedError(),
        501 => new NotImplementedError(),
        default => new InternalServerError(),
    };
}