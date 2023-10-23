<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Sentinel;


class AbortIfAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Sentinel::check())
            abort(401, 'The page you are trying to access is inaccessible to unauthenticated users.');
            
        return $next($request);       
    }
}
    
