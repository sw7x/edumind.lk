<?php

namespace App\Permissions\Traits;

use Sentinel;
use App\Common\SharedServices\UserSharedService;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Settings\PermissionCheckMessageEnum;
use App\Exceptions\InvalidUserTypeException;
use App\Permissions\PermissionResponse;


trait PermissionCheck{

    /*  authorize according to gate with authentication check and valid role check  */
    public static function hasPermission(string $ability, $args = []): void {       
        if(!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))
            throw new InvalidUserTypeException(PermissionCheckMessageEnum::INVALID_ROLE_MSG);
       
        $response = is_array($args) ? Gate::inspect($ability, [...$args]) : Gate::inspect($ability, $args);
        if (!$response->allowed())
            abort(403, $response->message() ?? PermissionCheckMessageEnum::FORBIDDEN_MSG);  
    
    }
    
    /*  get Response of the gate with authentication check and valid role check  */
    public static function hasPermissionResponse(string $ability, $args = []): PermissionResponse {
        if(!Sentinel::check())
            return PermRespMessages::noAuthResponse();

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))
            return PermRespMessages::invalidRoleResponse(); 

        $response = is_array($args) ? Gate::inspect($ability, [...$args]) : Gate::inspect($ability, $args);
        if (!$response->allowed())
            return PermRespMessages::forbiddenResponse($response->message() ?? '');

        return PermRespMessages::successResponse();
    }

}