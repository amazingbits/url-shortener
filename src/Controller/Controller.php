<?php

namespace Src\Controller;

class Controller
{
    protected function json(array $data, int $statusCode = 200, string $message = ""): void
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        $response = [
            "message" => $message,
            "data" => $data,
            "statusCode" => $statusCode
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }
}