<?php

namespace App\Permissions;

use Sentinel;
//use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use App\Common\SharedServices\UserSharedService;
use App\Exceptions\InvalidUserTypeException;
use Illuminate\Support\Facades\Gate;
use App\Permissions\PermissionCheckResultEnum;
use App\Permissions\PermissionCheckMessageEnum;
use App\Permissions\PermissionResponse;
use App\Permissions\PermissionCheckRedirectEnum;



class PermissionChecker{

	
	public static function authorize(string $ability, ...$args): void{
		$target 	= reset($args);
		$otherArgs 	= array_slice($args, 1);
		
		if ($target instanceof Model) {
    		$model = reset($args);			
    		self::authorizeOrAbortByModelRec($ability, $model, ...$otherArgs);

		} elseif(is_string($target)) {
    		$className = reset($args);
    		self::authorizeOrAbortByModelClass($ability, $className, ...$otherArgs);

		}else{
			abort(403, PermissionCheckMessageEnum::FORBIDDEN_MSG);
		}		
	}
	
	public static function getResponse(string $ability, ...$args): PermissionResponse {
		$target 	= reset($args);
		$otherArgs  = array_slice($args, 1);
		
		if ($target instanceof Model) {
    		$model = reset($args);		
    		return self::responseByModelRec($ability, $model, ...$otherArgs);

		} elseif(is_string($target)) {
    		$className = reset($args);
    		return self::responseByModelClass($ability, $className, ...$otherArgs);

		}else{
			return self::forbiddenResponse();
		}
	}



	private static function authorizeOrAbortByModelClass(
		string $ability, 
		string $modelClassName, 
		...$args
	): void {
		
		if(!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
            throw new InvalidUserTypeException(PermissionCheckMessageEnum::INVALID_ROLE_MSG);

        if(!Gate::allows($ability, [$modelClassName, ...$args]))
			abort(403, PermissionCheckMessageEnum::FORBIDDEN_MSG);	
	}

	private static function authorizeOrAbortByModelRec(string $ability, Model $model, ...$args): void {
		if(!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
            throw new InvalidUserTypeException(PermissionCheckMessageEnum::INVALID_ROLE_MSG);

		if(!Gate::allows($ability, [$model, ...$args]))
			abort(403, PermissionCheckMessageEnum::FORBIDDEN_MSG);	
	}
	
	

	private static function responseByModelClass(
		string $ability, 
		string $modelClassName, 
		...$args
	): PermissionResponse {

		if(!Sentinel::check())
           return self::noAuthResponse();

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
			return self::invalidRoleResponse();	

		if(!Gate::allows($ability, [$modelClassName, ...$args]))
			return self::forbiddenResponse();
		
		return self::successResponse();
	}	

	private static function responseByModelRec(
		string $ability, 
		Model $model, 
		...$args
	): PermissionResponse {
		
		if(!Sentinel::check())
            return self::noAuthResponse();

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->checkUserHaveValidRole($user))
			return self::invalidRoleResponse();	

		if(!Gate::allows($ability, [$model, ...$args]))
			return self::forbiddenResponse();

		return self::successResponse();	
	}



	private static function noAuthResponse(): PermissionResponse {
		return 	new PermissionResponse(
			PermissionCheckResultEnum::NO_AUTH,
			false,
			PermissionCheckMessageEnum::NO_AUTH_MSG,
			401,
			PermissionCheckRedirectEnum::ROUTE_LOGIN
		);
	}

	private static function invalidRoleResponse(): PermissionResponse {
		return 	new PermissionResponse(
			PermissionCheckResultEnum::INVALID_ROLE, 
			false, 
			PermissionCheckMessageEnum::INVALID_ROLE_MSG,
			null,
			PermissionCheckRedirectEnum::ROUTE_HOME
		);
	}

	private static function forbiddenResponse(): PermissionResponse {
		return new PermissionResponse(
			PermissionCheckResultEnum::FORBIDDEN, 
			false, 
			PermissionCheckMessageEnum::FORBIDDEN_MSG,
			403,
			PermissionCheckRedirectEnum::ROUTE_HOME
		);
	}

	private static function successResponse(): PermissionResponse {
		return new PermissionResponse(
			PermissionCheckResultEnum::SUCCESS, 
			true, 
			PermissionCheckMessageEnum::SUCCESS_MSG,
			200,
			null
		);
	}

}