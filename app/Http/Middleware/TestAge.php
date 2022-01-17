<?php

namespace App\Http\Middleware;

use Closure;

class TestAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        $age = 16;
        if ($age < 20){
            return "Rejected";
        }

        return $response;
    }
}
