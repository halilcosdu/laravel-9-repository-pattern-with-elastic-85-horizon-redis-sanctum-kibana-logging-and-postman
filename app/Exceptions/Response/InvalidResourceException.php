<?php

namespace App\Exceptions\Response;

use App\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidResourceException extends Exception
{
    /**
     * @var int
     */
    protected int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
}
