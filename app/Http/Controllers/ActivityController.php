<?php

namespace App\Http\Controllers;

use App\Contracts\Log\ActivityContract;
use App\Http\Requests\Log\DestroyRequest;
use App\Http\Requests\Log\IndexRequest;
use App\Http\Requests\Log\ShowRequest;
use App\Http\Resources\Log\ActivityResource;

class ActivityController extends Controller
{
    /**
     * @param  \App\Contracts\Log\ActivityContract  $activityContract
     */
    public function __construct(private readonly ActivityContract $activityContract)
    {
        //
    }

    /**
     * @param  \App\Http\Requests\Log\IndexRequest  $request
     * @return mixed
     */
    public function index(IndexRequest $request)
    {
        ['activities' => $activities, 'next' => $next] = $this->activityContract->all($request);

        return $this
            ->response()
            ->success(
                ActivityResource::collection($activities)
                    ->additional(['meta' => ['next' => $next]])
            );
    }

    /**
     * @param  \App\Http\Requests\Log\ShowRequest  $request
     * @param $logID
     * @return mixed
     */
    public function show(ShowRequest $request, $logID)
    {
        return $this->response()->success(
            new ActivityResource($this->activityContract->get($logID))
        );
    }

    /**
     * @param  \App\Http\Requests\Log\DestroyRequest  $request
     * @return mixed
     */
    public function destroy(DestroyRequest $request)
    {
        $this->activityContract->destroy();

        return $this->response()->noContent();
    }
}
