<?php

namespace Src\Error;

use Src\Core\BaseError;

class BadRequestError extends BaseError
{
    public function __construct(string $message = "Bad request")
    {
        parent::__construct(
            $message,
            400,
            "check the request syntax or parameters",
            "BadRequestError"
        );
    }
}