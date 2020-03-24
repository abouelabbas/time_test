<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class shopAdmin
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
        $guard = "shopadmin";
        if (! Auth::guard($guard)->check()) {
            return redirect('/shop-login');
         }
         return $next($request);
    }
}
