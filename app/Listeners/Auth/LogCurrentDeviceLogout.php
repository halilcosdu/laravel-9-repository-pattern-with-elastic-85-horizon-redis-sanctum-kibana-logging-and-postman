<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\CurrentDeviceLogout;

class LogCurrentDeviceLogout
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
     * @param  \Illuminate\Auth\Events\CurrentDeviceLogout  $event
     * @return void
     */
    public function handle(CurrentDeviceLogout $event)
    {
        activity([
            'action' => 'CurrentDeviceLogout',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
