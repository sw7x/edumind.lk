<?php
namespace App\Permissions\Traits;

use Sentinel;
use App\Exceptions\InvalidUserTypeException;
use App\Common\SharedServices\UserSharedService;
use App\Permissions\PermissionResponseMessages as PermRespMessages;
use App\Permissions\Settings\PermissionCheckMessageEnum;
use App\Permissions\PermissionResponse;


trait ValidRoleCheck{
    
    /*  authorize if authenticated and vhave valid role */
    public static function hasValidRole(): void {      
        if(!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))
            throw new InvalidUserTypeException(PermissionCheckMessageEnum::INVALID_ROLE_MSG);
    }
    
    /*  get response weather user have valid user role or not */
    public static function hasValidRoleResponse(string $ability, $args = []): PermissionResponse {      
        if(!Sentinel::check())
            return PermRespMessages::noAuthResponse();

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))
            return PermRespMessages::invalidRoleResponse();

        return PermRespMessages::successResponse();
    }

}