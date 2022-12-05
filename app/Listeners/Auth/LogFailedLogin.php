<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Failed;

class LogFailedLogin
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
     * @param  \Illuminate\Auth\Events\Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        activity([
            'action' => 'Failed',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
