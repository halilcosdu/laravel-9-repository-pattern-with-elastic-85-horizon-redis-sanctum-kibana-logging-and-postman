<?php

namespace App\Repositories\ES\Log;

use App\Contracts\Log\User\ActivityContract;
use App\Models\Log\Activity;
use App\Repositories\ES\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ActivityRepository
 */
class ActivityRepository extends Repository implements ActivityContract
{
    /**
     * @var string
     */
    public const INDEX = 'activities';

    /**
     * @param $searchAfter
     * @param $date
     * @param  null  $userID
     * @return array
     */
    public function searchForUser($userID, $searchAfter, $date)
    {
        $criteria = [
            [
                'term' => [
                    'causer_id' => $userID,
                ],
            ],
            [
                'range' => [
                    'date' => [
                        'gte' => $date['start'],
                        'lte' => $date['end'],
                    ],
                ],
            ],
        ];

        return $this->search($criteria, $searchAfter);
    }

    /**
     * @param $searchAfter
     * @param $date
     * @return array
     */
    public function all($searchAfter, $date)
    {
        $criteria = [
            [
                'range' => [
                    'date' => [
                        'gte' => $date['start'],
                        'lte' => $date['end'],
                    ],
                ],
            ],
        ];

        return $this->search($criteria, $searchAfter);
    }

    /**
     * @param $criteria
     * @param $searchAfter
     * @return array
     */
    private function search($criteria, $searchAfter)
    {
        $this->checkIndex(); // Once index is created there is no reason to check everytime. Purpose of development.

        $perPage = 10;
        $entities = $this->connection->search([
            'index' => self::getIndex(),
            'size' => $perPage + 1,
            'body' => [
                'search_after' => [$searchAfter],
                'query' => [
                    'bool' => [
                        'must' => $criteria,
                    ],
                ],
                'sort' => [
                    'date' => 'desc',
                ],
            ],
        ]);

        $next = null;
        $collection = resolve(Collection::class);
        foreach (array_slice($entities['hits']['hits'], 0, 10) as $entity) {
            $entity['_source']['date'] = Carbon::parse($entity['_source']['date']);
            $entity['_source']['identifier'] = $entity['_id'];
            $collection->push(new Activity($entity['_source']));
            $next = $entity['sort'][0];
        }

        if (collect($entities['hits']['hits'])->count() < $perPage) {
            $next = null;
        }

        return ['activities' => $collection, 'next' => $next];
    }

    /**
     * @param $logID
     * @return mixed
     *
     * @throws \Throwable
     */
    public function get($logID)
    {
        $entities = $this->connection->search([
            'index' => self::getIndex(),
            'size' => 1,
            'body' => [
                'query' => [
                    'term' => [
                        '_id' => $logID,
                    ],
                ],
                'sort' => [
                    'date' => 'desc',
                ],
            ],
        ]);

        $collection = resolve(Collection::class);
        foreach ($entities['hits']['hits'] as $entity) {
            $entity['_source']['date'] = Carbon::parse($entity['_source']['date']);
            $entity['_source']['identifier'] = $entity['_id'];
            $collection->push(new Activity($entity['_source']));
        }

        throw_if(is_null($collection->first()), new ModelNotFoundException());

        return $collection->first();
    }

    /**
     * @param  array  $attributes
     * @return \Elastic\Elasticsearch\Response\Elasticsearch|\Http\Promise\Promise
     */
    public function create(array $attributes)
    {
        $this->createIndexIfNotExists(self::getIndex());

        return $this->connection->index([
            'index' => self::getIndex(),
            'body' => $attributes,
        ]);
    }

    /**
     * @param $indexName
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    private function createIndexIfNotExists($indexName)
    {
        if ($this->connection->indices()->exists(['index' => $indexName])->getStatusCode() == 404) {
            $this->createIndex($indexName);
        }
    }

    /**
     * @param $indexName
     * @return void
     */
    private function createIndex($indexName): void
    {
        $this->connection->indices()->create([
            'index' => $indexName,
        ]);
    }

    /**
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function destroy()
    {
        if ($this->connection->indices()->exists(['index' => self::getIndex()])->getStatusCode() == 200) {
            $this->connection->indices()->delete([
                'index' => self::getIndex(),
            ]);
        }
    }

    /**
     * @return string
     */
    public static function getIndex()
    {
        return self::INDEX;
    }

    /**
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    private function checkIndex()
    {
        if ($this->connection->indices()->exists(['index' => self::getIndex()])->getStatusCode() == 404) {
            $this->create(['date' => now()]);
        }
    }
}
