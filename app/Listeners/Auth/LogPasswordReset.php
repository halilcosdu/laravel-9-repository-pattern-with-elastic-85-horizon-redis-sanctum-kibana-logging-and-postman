<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\PasswordReset;

class LogPasswordReset
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
     * @param  \Illuminate\Auth\Events\PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        activity([
            'action' => 'PasswordReset',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
