<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Sentinel;


class AuthUnlessRedirect
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
            return redirect()->route('home')->with([
                'message'   => 'The page you are trying to access is inaccessible to unauthenticated users.',
                'cls'       => 'flash-warning',
                'msgTitle'  => 'Access Denied !',
            ]);

        return $next($request);
        
            
    }
}
    
