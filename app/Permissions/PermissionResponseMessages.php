<?php

namespace App\Permissions;

use App\Permissions\PermissionCheckResultEnum;
use App\Permissions\PermissionCheckMessageEnum;
use App\Permissions\PermissionResponse;
use App\Permissions\PermissionCheckRedirectEnum;


class PermissionResponseMessages {

	public static function noAuthResponse(): PermissionResponse {
		return 	new PermissionResponse(
			PermissionCheckResultEnum::NO_AUTH,
			false,
			PermissionCheckMessageEnum::NO_AUTH_MSG,
			401,
			PermissionCheckRedirectEnum::ROUTE_LOGIN
		);
	}

	public static function invalidRoleResponse(): PermissionResponse {
		return 	new PermissionResponse(
			PermissionCheckResultEnum::INVALID_ROLE, 
			false, 
			PermissionCheckMessageEnum::INVALID_ROLE_MSG,
			null,
			PermissionCheckRedirectEnum::ROUTE_HOME
		);
	}

	public static function forbiddenResponse(?string $msg): PermissionResponse {
		return new PermissionResponse(
			PermissionCheckResultEnum::FORBIDDEN, 
			false, 
			$msg ?? PermissionCheckMessageEnum::FORBIDDEN_MSG,
			403,
			PermissionCheckRedirectEnum::ROUTE_HOME
		);
	}

	public static function successResponse(): PermissionResponse {
		return new PermissionResponse(
			PermissionCheckResultEnum::SUCCESS, 
			true, 
			PermissionCheckMessageEnum::SUCCESS_MSG,
			200,
			null
		);
	}

}