<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

use App\Common\SharedServices\UserSharedService;
use App\Exceptions\InvalidUserTypeException;


class ValidRole  
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
            abort(401, 'Authentication is required To access this page');

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
            throw new InvalidUserTypeException('The page you are trying to access is inaccessible because your user role is not valid.');

        return $next($request);
        
    }
}
