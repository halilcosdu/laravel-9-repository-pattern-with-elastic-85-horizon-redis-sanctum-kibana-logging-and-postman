<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class PipelineService
{
    /**
     * @param  \Illuminate\Pipeline\Pipeline  $pipeline
     */
    public function __construct(private readonly Pipeline $pipeline)
    {
        //
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $pipes
     * @return mixed
     */
    public function check(Request $request, array $pipes)
    {
        return $this->pipeline->send($request)->through($pipes)->thenReturn();
    }
}
