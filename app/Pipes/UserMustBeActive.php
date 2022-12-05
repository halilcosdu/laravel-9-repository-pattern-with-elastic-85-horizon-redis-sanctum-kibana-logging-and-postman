<?php

namespace App\Pipes;

use Closure;
use Illuminate\Http\Request;

/**
 *
 */
class UserMustBeActive
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->merge([
            "must_active" => 'Active Data'// Sending Custom data to Controller.
        ]);

        return $next($request);
    }
}
