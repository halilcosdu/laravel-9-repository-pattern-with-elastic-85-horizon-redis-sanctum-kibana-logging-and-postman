<?php

namespace App\Exceptions;

use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;

abstract class Exception extends BaseException
{
    /**
     * @var int
     */
    protected int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
