<?php

namespace App\Contracts\Response;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ResponseContract
 */
interface ResponseContract
{
    /**
     * @param  mixed  $resource
     * @param  int  $statusCode
     * @return Response
     */
    public function success(mixed $resource = [], int $statusCode = Response::HTTP_OK);

    /**
     * @param mixed $resource
     * @param  int  $statusCode
     * @param  Exception|null  $exception
     * @return Response
     */
    public function error(mixed $resource, int $statusCode = Response::HTTP_BAD_REQUEST, Exception $exception = null);

    /**
     * @return Response
     */
    public function noContent();
}
