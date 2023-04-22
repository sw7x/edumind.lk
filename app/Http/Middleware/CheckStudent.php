<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

class CheckStudent
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
            
            if($role == 'student'){
                return $next($request);
            }else{
                
                abort(403);
                //return redirect('/');
                /*return response()->view('form-submit-page',[
                    'message' => 'You dont have permission to access this page',
                    'title'   => 'Permission denied',
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ],200);*/
            }

        }else{
            //return redirect('/');
            //dd('')

            return redirect(route('auth.login'))->with([
            //return response()->view('form-submit-page',[
                'message' => 'You need login first to continue',
                'title'   => 'Permission denied',
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error!',
            ],200);



        }

    }
}
