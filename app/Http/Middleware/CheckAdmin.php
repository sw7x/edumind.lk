<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

class CheckAdmin
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
            if($role == 'admin'){
                return $next($request);
            }else{
                return redirect('/');
                /*
                return response()->json([
                    'status' => 'Error',
                    'message' => 'You dont have permission to access this service'
                ],403);
                */
            }

        }else{
            return redirect('/');
        }

    }
}
