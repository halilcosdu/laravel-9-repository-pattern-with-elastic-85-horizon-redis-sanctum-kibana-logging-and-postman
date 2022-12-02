<?php

namespace App\Exceptions;

use App\Exceptions\Exception as ApplicationException;
use App\Services\Response\JSONResponseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });

        $this->renderable(function (NotFoundHttpException $exception) {
            $response = resolve(JSONResponseService::class);

            return $response->error(
                [],
                $exception->getStatusCode(),
                $exception
            );
        });

        $this->renderable(function (ValidationException $exception) {
            $response = resolve(JSONResponseService::class);

            return $response->error(
                ['inputs' => $exception->validator->errors()],
                $exception->status,
                $exception
            );
        });

        $this->renderable(function (HttpException $exception) {
            $response = resolve(JSONResponseService::class);

            return $response->error(
                [],
                $exception->getStatusCode(),
                $exception
            );
        });

        $this->renderable(function (ApplicationException $exception) {
            $response = resolve(JSONResponseService::class);

            return $response->error(
                [],
                $exception->getStatusCode(),
                $exception
            );
        });

        $this->renderable(function (AuthenticationException $exception) {
            $response = resolve(JSONResponseService::class);

            return $response->error([], Response::HTTP_UNAUTHORIZED, $exception);
        });

        $this->renderable(function (AuthorizationException $exception) {
            $response = resolve(JSONResponseService::class);

            return $response->error([], Response::HTTP_FORBIDDEN, $exception);
        });

        $this->renderable(function (Throwable $exception) {
            $response = resolve(JSONResponseService::class);

            return $response->error([], Response::HTTP_BAD_REQUEST, $exception);
        });
    }
}
