<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;
use App\Models\Role as RoleModel;
        
class AccessAdminPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        if(sentinel::check()){
            $userRole = Sentinel::getUser()->roles()->first()->slug;

            if($userRole != RoleModel::STUDENT){
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
    }
}
