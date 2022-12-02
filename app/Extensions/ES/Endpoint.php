<?php

namespace App\Extensions\ES;

use Elasticsearch\Common\Exceptions\InvalidArgumentException;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 *
 */
class Endpoint extends AbstractEndpoint
{
    /**
     * @param  array  $body
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setBody(array $body)
    {
        if (isset($body) !== true) {
            return $this;
        }
        $this->body = $body;

        return $this;
    }

    /**
     * @return array
     */
    public function getParamWhitelist(): array
    {
        return [
            'query',
        ];
    }

    /**
     * @return string
     */
    public function getURI(): string
    {
        return '/_sql';
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'GET';
    }
}
