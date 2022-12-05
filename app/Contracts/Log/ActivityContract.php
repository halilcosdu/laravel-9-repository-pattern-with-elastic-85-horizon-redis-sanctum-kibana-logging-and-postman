<?php

namespace App\Contracts\Log;

use Illuminate\Http\Request;

interface ActivityContract
{
    /**
     * @param  array  $attributes
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function log(array $attributes, Request $request);

    /**
     * @return mixed
     */
    public function all(Request $request);

    /**
     * @param $logID
     * @return mixed
     */
    public function get($logID);

    /**
     * @param  Request  $request
     * @return array
     *
     * @throws \Exception
     */
    public function filterForUserFromRequest(Request $request);

    /**
     * @return void
     *
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function destroy();
}
