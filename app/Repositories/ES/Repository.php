<?php

namespace App\Repositories\ES;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client as Connection;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as Query;

/**
 * Class Repository
 */
class Repository implements RepositoryInterface
{
    /**
     * Default index name if not defined from subclasses.
     */
    public const INDEX = 'default';
    /**
     * @var ClientBuilder
     */
    protected ClientBuilder $clientBuilder;

    /**
     * @var \Illuminate\Database\Query\Builder|Builder
     */
    protected Query|Builder $query;

    /**
     * @var Connection
     */
    protected Connection $connection;

    /**
     * Repository constructor.
     *
     * @param  \Elastic\Elasticsearch\ClientBuilder  $clientBuilder
     * @param  Query  $query
     */
    public function __construct(
        ClientBuilder $clientBuilder,
        Query $query
    ) {
        $this->query = $query;
        $this->clientBuilder = $clientBuilder;
    }

    /**
     * @return $this
     */
    public function connectCluster()
    {
        $hosts = config('elasticsearch.log_hosts');

        $hosts = array_map(function ($item) {
            return trim($item);
        }, array_filter(explode(',', $hosts)));

        $this->connection = $this->clientBuilder->create()
            ->setSSLVerification(false) // If not local development you can remove.
            ->setHttpClient(new Client(['verify' => false])) // If not local development you can remove.
            ->setBasicAuthentication(
                config('elasticsearch.auth.basic.username'),
                config('elasticsearch.auth.basic.password')
            )
            ->setHosts($hosts)
            ->build();

        return $this;
    }

    /**
     * @return string
     */
    public static function getIndex()
    {
        return self::INDEX;
    }
}
