<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Sentinel;



class CanAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    } */


    public function handle(Request $request, Closure $next, ...$roles)
    {

        //dd($roles);


        if(sentinel::check()){
            $userRole = Sentinel::getUser()->roles()->first()->slug;

            /*foreach($roles as $role){
                if ($role == $userRole){
                    return $next($request);
                }
            }*/
            if(in_array($userRole, $roles)){
                return $next($request);
            }else{

                /*return redirect(route('no-permission'))->with([
                    'message'     => 'You dont have permission to access this page',
                    'cls'         => "flash-warning",
                    'msgTitle'    => 'Warning !',
                ]);*/

                abort(403);

            }


        }else{
            return redirect(route('auth.login'))->with([
                'message'     => 'You dont have permission to access this page',
                'cls'         => "flash-warning",
                'msgTitle'    => 'Warning !',
            ]);
        }
        //dd(route('auth.login'));






        //abort(404);
    }
}
