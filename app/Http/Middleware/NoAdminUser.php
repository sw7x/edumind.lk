<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

class NoAdminUser
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


        if(sentinel::check()){
            $role = Sentinel::getUser()->roles()->first()->slug;
            //$role ='';
            //dd($role);


            if($role == 'admin' || $role == 'editor' || $role == 'marketer'){
                return redirect('/ss');
            }else{
                return $next($request);
            }
        }else{
            return $next($request);
        }

    }
}
