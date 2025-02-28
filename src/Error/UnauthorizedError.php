<?php

namespace Src\Error;

use Src\Core\BaseError;

class UnauthorizedError extends BaseError
{
    public function __construct()
    {
        parent::__construct(
            "Unauthorized access",
            401,
            "check authentication credentials",
            "UnauthorizedError"
        );
    }
}