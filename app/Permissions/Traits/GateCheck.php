<?php

namespace App\Permissions\Traits;

use Illuminate\Support\Facades\Gate;
use App\Permissions\PermissionResponseMessages as PermRespMessages;
use App\Permissions\Settings\PermissionCheckMessageEnum;
use App\Permissions\PermissionResponse;


trait GateCheck{

    /*	authorize according to gate  */
	public static function hasGateAllowed(string $ability, $args = []): void {	
		//dd($args);
		$response = Gate::inspect($ability, ...$args);
		if (!$response->allowed())
			abort(403, $response->message() ?? PermissionCheckMessageEnum::FORBIDDEN_MSG);	
	}
	
	/*	get Response of the gate  */
	public static function hasGateAllowedResponse(string $ability, $args = []): PermissionResponse {		
		$response 	= Gate::inspect($ability, ...$args);
		$msg 		= $response->message();
		$response 	= $response->allowed() ? PermRespMessages::successResponse() : PermRespMessages::forbiddenResponse($msg);
		return $response;
	}
}