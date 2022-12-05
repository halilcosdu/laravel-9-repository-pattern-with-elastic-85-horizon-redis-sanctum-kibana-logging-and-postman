<?php

namespace App\Extensions\ES;

use Elasticsearch\Namespaces\AbstractNamespace;

class SQLNamespace extends AbstractNamespace
{
    /**
     * @param $query
     * @param  null  $cursor
     * @param  int  $fetchSize
     * @return array|callable
     */
    public function exec($query, $cursor = null, int $fetchSize = 200)
    {
        $body = $cursor ? ['query' => $query, 'cursor' => $cursor, 'fetch_size' => $fetchSize] :
            ['query' => $query, 'fetch_size' => $fetchSize];

        $endpoint = new Endpoint();
        $endpoint->setBody($body);

        return $this->performRequest($endpoint);
    }
}
