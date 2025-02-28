<?php

namespace Src\Error;

use Src\Core\BaseError;

class MethodNotAllowedError extends BaseError
{
    public function __construct(string $message = "Method Not Allowed")
    {
        parent::__construct(
            $message,
            405,
            "check the allowed HTTP methods for this endpoint",
            "MethodNotAllowedError"
        );
    }
}