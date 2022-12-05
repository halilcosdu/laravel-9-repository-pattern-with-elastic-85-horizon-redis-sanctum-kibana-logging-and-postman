<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
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
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        activity([
            'action' => 'Logout',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
