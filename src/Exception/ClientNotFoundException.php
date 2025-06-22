<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientNotFoundException extends NotFoundHttpException
{
    public function __construct(string $message = 'Client not found.', \Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
