<?php

namespace App\Listeners\Auth;

class LogVerified
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
     * @param  \App\Listeners\Auth\LogVerified  $event
     * @return void
     */
    public function handle(LogVerified $event)
    {
        activity([
            'action' => 'LogVerified',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
