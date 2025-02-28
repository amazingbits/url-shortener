<?php

namespace Src\Core;

class BaseError extends \Exception
{
    protected int $statusCode;
    protected string $action;
    protected string $errorName;

    public function __construct(string $message, int $statusCode, string $action, string $errorName)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->action = $action;
        $this->errorName = $errorName;
    }

    public function toArray(): array
    {
        return [
            "error" => $this->errorName,
            "message" => $this->getMessage(),
            "action" => $this->action,
            "statusCode" => $this->statusCode,
        ];
    }
}