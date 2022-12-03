<?php

namespace App\Exceptions\Query;

use App\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class SlowQueryException extends Exception
{
    /**
     * @var int
     */
    protected int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
}
