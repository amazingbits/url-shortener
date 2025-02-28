<?php

namespace Src\Error;

use Src\Core\BaseError;

class ExpiredUrlError extends BaseError
{
    public function __construct()
    {
        parent::__construct(
            "This URL has expired and is no longer available.",
            410,
            "Please check the URL or request a new one.",
            "ExpiredUrlError"
        );
    }
}