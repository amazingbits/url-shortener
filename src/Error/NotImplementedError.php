<?php

namespace Src\Error;

use Src\Core\BaseError;

class NotImplementedError extends BaseError
{
    public function __construct()
    {
        parent::__construct(
            "Not Implemented",
            501,
            "this method is not supported by the server",
            "NotImplementedError"
        );
    }
}