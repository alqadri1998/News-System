<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }

        if ($this->auth->guard('author')) {
            $loginRoute = "cms.author.login_view";
            return route($loginRoute);

        } else if($this->auth->guard('admin')){
            $loginRoute = "cms.admin.login_view";
            return route($loginRoute);
        }
    }
}
