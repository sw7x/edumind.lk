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
use App\Permissions\PermissionResponseMessages as PermRespMessages;

class PermissionChecker{

	/*	authorize if authenticated  */
	public static function auth(): void {		
		if(!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);       
	}	
	
	/*	authorize if authenticated and vhave valid role */
	public static function validRole(): void {		
		if(!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))
            throw new InvalidUserTypeException(PermissionCheckMessageEnum::INVALID_ROLE_MSG);
	}

	/*	authorize according to gate with authentication check and valid role check  */
	public static function authorize(string $ability, $args = []): void {		
		if(!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))
            throw new InvalidUserTypeException(PermissionCheckMessageEnum::INVALID_ROLE_MSG);
       
		$response = is_array($args) ? Gate::inspect($ability, [...$args]) : Gate::inspect($ability, $args);
		if (!$response->allowed())
			abort(403, $response->message() ?? PermissionCheckMessageEnum::FORBIDDEN_MSG);	
	
	}



	/*	get response of the authenticated status  */
	public static function getAuthResponse(string $ability, $args = []): PermissionResponse {		
		$response = Sentinel::check() ? PermRespMessages::successResponse() : PermRespMessages::noAuthResponse();		
		return $response;
	}
	
	/*	get response weather user have valid user role or not */
	public static function getValidRoleResponse(string $ability, $args = []): PermissionResponse {		
		if(!Sentinel::check())
			return PermRespMessages::noAuthResponse();

		$user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))
            return PermMessages::invalidRoleResponse();

		return PermRespMessages::successResponse();
	}

	/*	get Response of the gate with authentication check and valid role check  */
	public static function getResponse(string $ability, $args = []): PermissionResponse {
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

	
	
	/*	authorize according to gate  */
	public static function authorizeGate(string $ability, $args = []): void {	
		//dd($args);
		$response = Gate::inspect($ability, ...$args);
		if (!$response->allowed())
			abort(403, $response->message() ?? PermissionCheckMessageEnum::FORBIDDEN_MSG);	
	}
	

	/*	get Response of the gate  */
	public static function getGateResponse(string $ability, $args = []): PermissionResponse {		
		$response 	= Gate::inspect($ability, ...$args);
		$msg 		= $response->message();
		$response 	= $response->allowed() ? PermRespMessages::successResponse() : PermRespMessages::forbiddenResponse($msg);
		return $response;
	}

}