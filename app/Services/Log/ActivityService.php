<?php

namespace App\Services\Log;

use App\Contracts\Log\ActivityContract;
use App\Contracts\Log\User\ActivityContract as UserActivityContract;
use App\Extensions\ES\Log\ActivityBag;
use App\Jobs\Log\Activity;
use App\Services\DateService;
use Illuminate\Http\Request;

/**
 *
 */
class ActivityService implements ActivityContract
{
    /**
     * @param  \App\Extensions\ES\Log\ActivityBag  $activityBag
     * @param  \App\Contracts\Log\User\ActivityContract  $activityContract
     * @param  \App\Services\DateService  $dateService
     */
    public function __construct(
        private readonly ActivityBag $activityBag,
        private readonly UserActivityContract $activityContract,
        private readonly DateService $dateService
    ) {
        //
    }

    /**
     * @param  Request  $request
     * @return array
     *
     * @throws \Exception
     */
    public function filterForUserFromRequest(Request $request)
    {
        $searchAfter = $request->next ?? now()->addHour()->getPreciseTimestamp();
        $range = $this->dateService->getRangeSettingsFromRangeArray($request->date, true);

        return $this->activityContract
            ->connectCluster()
            ->searchForUser(
                $request->user()->id,
                $searchAfter,
                $range['settings']
            );
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     * @throws \Exception
     */
    public function all(Request $request)
    {
        $searchAfter = $request->next ?? now()->addHour()->getPreciseTimestamp();
        $range = $this->dateService->getRangeSettingsFromRangeArray($request->date, true);

        return $this->activityContract
            ->connectCluster()
            ->all(
                $searchAfter,
                $range['settings']
            );
    }

    /**
     * @param $logID
     * @return mixed
     * @throws \Throwable
     */
    public function get($logID)
    {
        return $this->activityContract->connectCluster()->get($logID);
    }

    /**
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function destroy()
    {
        $this->activityContract->connectCluster()->destroy();
    }

    /**
     * @param  array  $attributes
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Foundation\Bus\PendingClosureDispatch|\Illuminate\Foundation\Bus\PendingDispatch
     */
    public function log(array $attributes, Request $request)
    {
        $this->activityBag
            ->setIP($request->ip())
            ->setDate(now())
            ->setAction($attributes['action'])
            ->setCauserID($request->user()?->id)
            ->setUri($request->getRequestUri())
            ->setMethod($request->getMethod())
            ->setAgent($request->userAgent());

        collect($attributes)
            ->except(['ip', 'date', 'causer_id', 'action', 'uri', 'method', 'agent'])
            ->each(function ($attribute, $key) {
                $this->activityBag->{'set'.$key}($attribute);
            });

        return dispatch(
            new Activity($this->activityBag)
        );
    }
}
