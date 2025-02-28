<?php

namespace Src\Error;

use Src\Core\BaseError;

class NotFoundError extends BaseError
{
    public function __construct()
    {
        parent::__construct(
            "endpoint not found",
            404,
            "consult API docs or contact de administrator",
            "NotFoundError"
        );
    }
}