<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Lockout;

class LogLockout
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
     * @param  \Illuminate\Auth\Events\Lockout  $event
     * @return void
     */
    public function handle(Lockout $event)
    {
        activity([
            'action' => 'Lockout',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
