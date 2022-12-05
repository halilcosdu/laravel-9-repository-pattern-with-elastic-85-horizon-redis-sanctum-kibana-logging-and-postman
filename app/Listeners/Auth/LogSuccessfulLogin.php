<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
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
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        activity([
            'action' => 'Login',
            'info' => [
                'event' => $event,
            ],
        ]);
    }
}
