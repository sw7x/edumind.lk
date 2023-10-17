<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

use App\Common\SharedServices\UserSharedService;
use App\Exceptions\InvalidUserTypeException;


class ValidRoleUnlessRedirect  
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
        if(!sentinel::check())
            return redirect()->route('auth.login')->with([
                'message'   => 'Authentication is required To access this page',
                'cls'       => 'flash-warning',
                'msgTitle'  => 'Access Denied !',
            ]);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
            return redirect()->route('home')->with([
                'message'   => 'The page you are trying to access is inaccessible because your user role is not valid.',
                'cls'       => 'flash-warning',
                'msgTitle'  => 'Access Denied !',
            ]);

        return $next($request);
        
    }
}
