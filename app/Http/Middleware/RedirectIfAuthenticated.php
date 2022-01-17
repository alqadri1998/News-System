<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect(RouteServiceProvider::HOME);
        // }

        if ($guard == 'author'){
            if (Auth::guard('author')->check()){
                $user = Auth::guard('author')->user();
                if ($user->status == "Active"){
                    return redirect()->route('cms.admin.dashboard');
                }else{
                    // return redirect()->route('cms.author.blocked');
                }
            }
        } else if ($guard == 'admin'){
            if (Auth::guard('admin')->check()){
                $user = Auth::guard('admin')->user();
                if ($user->status == "Active"){
                    return redirect()->route('cms.admin.dashboard');
                }else{
                    // return redirect()->route('cms.author.blocked');
                }
            }
        }
        return $next($request);
    }
}
