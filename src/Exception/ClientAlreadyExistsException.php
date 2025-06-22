<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ClientAlreadyExistsException extends ConflictHttpException
{
    public function __construct(string $message = 'Client already exists.', ?\Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
