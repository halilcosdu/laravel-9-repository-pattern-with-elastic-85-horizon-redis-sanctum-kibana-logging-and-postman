<?php

use App\Contracts\Log\ActivityContract;
use WhichBrowser\Parser;

if (! function_exists('transaction')) {
    /**
     * @param  callable  $callback
     * @return mixed
     */
    function transaction(callable $callback)
    {
        return resolve('db.connection')->transaction($callback);
    }
}

if (! function_exists('activity')) {
    /**
     * @param  array  $attributes
     * @return mixed
     */
    function activity(array $attributes)
    {
        return resolve(ActivityContract::class)->log($attributes, request());
    }
}

if (! function_exists('agent')) {
    /**
     * @param $agent
     * @return Parser
     */
    function agent($agent)
    {
        return new WhichBrowser\Parser($agent);
    }
}
