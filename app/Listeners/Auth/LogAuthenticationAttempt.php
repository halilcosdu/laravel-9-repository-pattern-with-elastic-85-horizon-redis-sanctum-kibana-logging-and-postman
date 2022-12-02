<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogAuthenticationAttempt
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
     * @param  \Illuminate\Auth\Events\Attempting  $event
     * @return void
     */
    public function handle(Attempting $event)
    {
        activity([
            'action' => 'Attempting',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
