<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Authenticated;

class LogAuthenticated
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
     * @param  \Illuminate\Auth\Events\Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        activity([
            'action' => 'Authenticated',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
