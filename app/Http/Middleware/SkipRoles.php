<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

use App\Common\SharedServices\UserSharedService;
use App\Models\Role as RoleModel;


class SkipRoles  
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed

    */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $roleArr = array();
        foreach ($roles as $role) {
            $role = trim($role);
            
            if(substr_count($role,'::') === 1){
                list($className, $constantName) = explode("::", $role);
                if($className == 'Role' || $className == 'RoleModel')
                    $roleArr[] = constant('\App\Models\Role::' . $constantName);
            }

            if(substr_count($role,'::') === 0)
                $roleArr[] = $role;           
        }
        

        if(!Sentinel::check())
            abort(401, 'Authentication is required To access this page');

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
            throw new InvalidUserTypeException('The page you are trying to access is inaccessible because your user role is not valid.');

        if(!empty($roleArr)){
            /*
            if((new UserSharedService)->hasRole($user, RoleModel::ADMIN) && !in_array(RoleModel::ADMIN, $roleArr))
                abort(404, 'This page has nothing to do with your user role.');
            */

            if((new UserSharedService)->isAllowed($user, $roleArr))
                abort(403, 'The page you are trying to access is inaccessible because you dont have permissions.');
        }

        return $next($request);
        
    }
}

