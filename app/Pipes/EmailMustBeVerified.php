<?php

namespace App\Pipes;

use Closure;
use Illuminate\Http\Request;

/**
 *
 */
class EmailMustBeVerified
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()->hasVerifiedEmail()) {
            return false;
        }

        $request->merge([
            "custom_data" => 'Custom Data'// Sending Custom data to Controller.
        ]);

        return $next($request);
    }
}
