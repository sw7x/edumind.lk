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
use \BadMethodCallException;
use \ArgumentCountError;


class PermissionChecker{

	public static function authorize(string $ability, $args = []): void{
		if (is_string($args)) {
			self::authorizeOrAbortByModelClass($ability, $args);

		} elseif ($args instanceof Model) {
    		self::authorizeOrAbortByModelRec($ability, $args);

		} elseif (is_array($args) && !empty($args)) {
			$target 	= reset($args);
			$otherArgs  = array_slice($args, 1);

			if (is_string($target)) {
    			self::authorizeOrAbortByModelClass($ability, $target, ...$otherArgs);

			} elseif ($target instanceof Model) {
				self::authorizeOrAbortByModelRec($ability, $target, ...$otherArgs);
    			
			} else {
				abort(403, PermissionCheckMessageEnum::FORBIDDEN_MSG);

			}

		} else {
			abort(403, PermissionCheckMessageEnum::FORBIDDEN_MSG);

		}	
	}
	
	public static function getResponse(string $ability, $args = []): PermissionResponse {
		if (is_string($args)) {
			return self::responseByModelClass($ability, $args);

		} elseif ($args instanceof Model) {
    		return self::responseByModelRec($ability, $args);

		} elseif (is_array($args) && !empty($args)) {
			$target 	= reset($args);
			$otherArgs  = array_slice($args, 1);

			if (is_string($target)) {
    			return self::responseByModelClass($ability, $target, ...$otherArgs);

			} elseif ($target instanceof Model) {
				return self::responseByModelRec($ability, $target, ...$otherArgs);
    			
			} else {
				return self::forbiddenResponse();
			}

		} else {
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

	public static function auth(): void {		
		if(!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);       
	}	

	public static function haveValidRole(): void {		
		if(!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))
            throw new InvalidUserTypeException(PermissionCheckMessageEnum::INVALID_ROLE_MSG);
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