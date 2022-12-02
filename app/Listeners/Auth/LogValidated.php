<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogValidated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Validated  $event
     * @return void
     */
    public function handle(Validated $event)
    {
        activity([
            'action' => 'LogValidated',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
