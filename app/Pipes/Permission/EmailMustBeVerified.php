<?php

namespace App\Pipes\Permission;

use Closure;

/**
 *
 */
class EmailMustBeVerified
{
    /**
     * @param  array  $attributes
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(array $attributes, Closure $next)
    {
        if (! $attributes['request']->user()->hasVerifiedEmail()) {
            return false;
        }

        $attributes['request']->merge([ // Sending Custom data to Controller.
            'custom_data' => 'Custom Data',
        ]);

        return $next($attributes);
    }
}
