<?php

use Src\Core\BaseError;

require_once __DIR__ . "/vendor/autoload.php";

set_exception_handler(function ($exception) {
    if ($exception instanceof BaseError) {
        $response = $exception->toArray();
        http_response_code($response['statusCode']);
    } else {
        $response = [
            "error" => "UnknownError",
            "message" => $exception->getMessage(),
            "action" => "contact support",
            "statusCode" => 500,
        ];
        http_response_code(500);
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
});