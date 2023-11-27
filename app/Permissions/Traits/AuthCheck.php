<?
namespace App\Permissions\Traits;

use Sentinel;
use App\Permissions\PermissionResponse;
use App\Permissions\Settings\PermissionCheckMessageEnum;
use App\Permissions\PermissionResponseMessages as PermRespMessages;

trait AuthCheck{
    
    /*	authorize if authenticated  */
    public static function hasAuth(): void {
        if (!Sentinel::check())
            abort(401, PermissionCheckMessageEnum::NO_AUTH_MSG);        
    }    
	
	/*	get response of the authenticated status  */
    public static function hasAuthResponse(string $ability, $args = []): PermissionResponse {
        $response = Sentinel::check() ? PermRespMessages::successResponse() : PermRespMessages::noAuthResponse();
        return $response;
    }
}