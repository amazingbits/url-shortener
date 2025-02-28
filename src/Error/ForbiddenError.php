<?php

namespace Src\Error;

use Src\Core\BaseError;

class ForbiddenError extends BaseError
{
    public function __construct()
    {
        parent::__construct(
            "Forbidden",
            403,
            "you don't have permission to access this resource",
            "ForbiddenError"
        );
    }
}