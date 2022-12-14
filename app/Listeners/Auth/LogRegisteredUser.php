<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Registered;

class LogRegisteredUser
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
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        activity([
            'action' => 'Registered',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
