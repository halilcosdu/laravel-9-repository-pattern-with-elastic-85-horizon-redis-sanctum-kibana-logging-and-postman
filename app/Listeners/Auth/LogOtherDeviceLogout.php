<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\OtherDeviceLogout;

class LogOtherDeviceLogout
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
     * @param  \Illuminate\Auth\Events\OtherDeviceLogout  $event
     * @return void
     */
    public function handle(OtherDeviceLogout $event)
    {
        activity([
            'action' => 'OtherDeviceLogout',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
