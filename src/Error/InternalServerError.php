<?php

namespace Src\Error;

use Src\Core\BaseError;

class InternalServerError extends BaseError
{
    public function __construct()
    {
        parent::__construct(
            "Internal server error",
            500,
            "please try again later or contact support",
            "InternalServerError"
        );
    }
}