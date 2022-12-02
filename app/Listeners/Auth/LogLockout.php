<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
