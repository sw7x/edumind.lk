<?php

namespace App\Permissions;

use Sentinel;
//use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use App\Common\SharedServices\UserSharedService;
use App\Exceptions\InvalidUserTypeException;
use Illuminate\Support\Facades\Gate;
use App\Permissions\PermissionDeniedTypesEnum;
use App\Permissions\PermissionDeniedMessageEnum;




class PermissionChecker{

	
	public static function authorize(string $ability, ...$args){
		$target 	= reset($args);
		$otherArgs 	= array_slice($args, 1);
		
		if ($target instanceof Model) {
    		$model = reset($args);			
    		self::authorizeOrAbortByModelRec($ability, $model, ...$otherArgs);

		} elseif(is_string($target)) {
    		$className = reset($args);
    		self::authorizeOrAbortByModelClass($ability, $className, ...$otherArgs);

		}else{
			abort(403, PermissionDeniedMessageEnum::FORBIDDEN_MSG);
		}		
	}
	

	public static function getStatus(string $ability, ...$args){
		$target 	= reset($args);
		$otherArgs  = array_slice($args, 1);
		
		if ($target instanceof Model) {
    		$model = reset($args);		
    		return self::inspectByModelRec($ability, $model, ...$otherArgs);

		} elseif(is_string($target)) {
    		$className = reset($args);
    		return self::inspectByModelClass($ability, $className, ...$otherArgs);

		}else{
			return PermissionDeniedTypesEnum::FORBIDDEN;				
		}
	}



	private static function authorizeOrAbortByModelClass(string $ability, string $modelClassName, ...$args){
		if(!Sentinel::check())
            abort(401, PermissionDeniedMessageEnum::NO_AUTH_MSG);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
            throw new InvalidUserTypeException(PermissionDeniedMessageEnum::INVALID_ROLE_MSG);

        if(!Gate::allows($ability, [$modelClassName, ...$args]))
			abort(403, PermissionDeniedMessageEnum::FORBIDDEN_MSG);	
	}

	private static function authorizeOrAbortByModelRec(string $ability, Model $model, ...$args){
		if(!Sentinel::check())
            abort(401, PermissionDeniedMessageEnum::NO_AUTH_MSG);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
            throw new InvalidUserTypeException(PermissionDeniedMessageEnum::INVALID_ROLE_MSG);

		if(!Gate::allows($ability, [$model, ...$args]))
			abort(403, PermissionDeniedMessageEnum::FORBIDDEN_MSG);	
	}
	
	

	private static function inspectByModelClass(string $ability, string $modelClassName, ...$args){
		if(!Sentinel::check())
            return PermissionDeniedTypesEnum::NO_AUTH;

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
			return PermissionDeniedTypesEnum::INVALID_ROLE;

		if(!Gate::allows($ability, [$modelClassName, ...$args]))
			return PermissionDeniedTypesEnum::FORBIDDEN;

		return true;
	}	

	private static function inspectByModelRec(string $ability, Model $model, ...$args){
		if(!Sentinel::check())
            return PermissionDeniedTypesEnum::NO_AUTH;

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
			return PermissionDeniedTypesEnum::INVALID_ROLE;

		if(!Gate::allows($ability, [$model, ...$args]))
			return PermissionDeniedTypesEnum::FORBIDDEN;

		return true;	
	}

}