<?php

namespace App\Jobs\Log;

use App\Contracts\Log\User\ActivityContract;
use App\Extensions\ES\Log\ActivityBag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Activity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private readonly ActivityBag $activityBag)
    {
        $this->onQueue('activity');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ActivityContract $activityContract)
    {
        $activityContract->connectCluster()->create($this->activityBag->toArray());
    }
}
