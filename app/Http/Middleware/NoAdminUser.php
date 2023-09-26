<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;
use App\Models\Role as RoleModel;


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

            if($role == RoleModel::ADMIN || $role == RoleModel::EDITOR || $role == RoleModel::MARKETER){
            //if($role == 'admin' || $role == 'editor' || $role == 'marketer'){
                return redirect('/ss');
            }else{
                return $next($request);
            }
        }else{
            return $next($request);
        }

    }
}
