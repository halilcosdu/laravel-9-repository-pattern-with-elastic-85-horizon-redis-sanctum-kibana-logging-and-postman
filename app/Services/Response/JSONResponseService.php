<?php

namespace App\Services\Response;

use App\Contracts\Response\ResponseContract;
use App\Exceptions\Response\InvalidResourceException;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Collection;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class JSONResponseService
 */
class JSONResponseService implements ResponseContract
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var bool
     */
    private bool $success;

    /**
     * @var ?Throwable
     */
    private ?Throwable $exception = null;

    /**
     * JSONResponseService constructor.
     *
     * @param  \Illuminate\Routing\ResponseFactory  $responseFactory
     */
    public function __construct(private readonly ResponseFactory $responseFactory)
    {
        //
    }

    /**
     * @param  mixed|array  $resource
     * @param  int  $statusCode
     * @return JsonResponse|ResponseAlias
     * @throws InvalidResourceException|\ReflectionException
     */
    public function success(mixed $resource = [], int $statusCode = ResponseAlias::HTTP_OK)
    {
        $this->statusCode = $statusCode;
        $this->success = true;

        return $this->render($resource);
    }

    /**
     * @param  array  $resource
     * @param  int  $statusCode
     * @param  Exception|null  $exception
     * @return JsonResponse|ResponseAlias
     *
     * @throws InvalidResourceException|\ReflectionException
     */
    public function error(
        mixed $resource,
        int $statusCode = ResponseAlias::HTTP_BAD_REQUEST,
        Throwable $exception = null
    ) {
        $this->statusCode = $statusCode;
        $this->success = false;
        $this->exception = $exception;

        return $this->render($resource);
    }

    /**
     * @return Response
     */
    public function noContent()
    {
        return $this->responseFactory->noContent();
    }

    /**
     * @param  mixed  $resource
     * @return JsonResponse
     *
     * @throws InvalidResourceException|\ReflectionException
     */
    private function render(mixed $resource)
    {
        if ($resource instanceof JsonResource) {
            return $resource
                ->additional($resource->additional + $this->generateMetaData())
                ->response()
                ->setStatusCode($this->statusCode);
        }

        if ($resource instanceof Model || $resource instanceof Collection) {
            $resource = $resource->toArray();
        }

        if (! is_array($resource)) {
            throw new InvalidResourceException;
        }

        $output = $this->success ? ['data' => $resource] + $this->generateMetaData()
            : array_merge_recursive(['errors' => $resource], $this->generateMetaData());

        return $this->responseFactory->json($output, $this->statusCode);
    }

    /**
     * @return array
     *
     * @throws \ReflectionException
     * @throws \ReflectionException
     */
    private function generateMetaData()
    {
        $meta = [];
        if ($this->exception) {
            $meta['errors']['message'] = $this->exception->getMessage();
            if (config('app.debug')) {
                $meta['errors']['exception'] = (new ReflectionClass($this->exception))->getShortName();
                $meta['errors']['file'] = $this->exception->getFile();
                $meta['errors']['line'] = $this->exception->getLine();
                //$meta['errors']['trace'] = $this->exception->getTrace();
            }
        }

        $meta['success'] = $this->success;
        $meta['execution_time'] = number_format(microtime(true) - LARAVEL_START, 3);

        return $meta;
    }
}
