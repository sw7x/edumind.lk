<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Sentinel;

use App\Permissions\PermissionChecker;
use App\Permissions\Abilities\AuthAbilities;


class ChangeAdminPasswordController extends Controller
{

    public function changePassword(Request $request) {
        
        try{
            $response = PermissionChecker::getGateResponse(AuthAbilities::CHANGE_PASSWORD);
            if (!$response->allowed())
                throw new CustomException($response->message() ?? 'Permission denied');

            $oldPassword    = $request->old_password;
            $password       = $request->password;

            if($password == '')
                throw new CustomException('invalid value for current password');

            if($oldPassword == '')
                throw new CustomException('invalid value for new password');

            $user = Sentinel::getUser();
            if(is_null($user))
                abort(401, "You need to login before change your password");


            $hasher = Sentinel::getHasher();
            if ($hasher->check($oldPassword, $user->password)) {
                Sentinel::update($user, array('password' => $password));
                return Response::json(['status' => 'success', 'data' => null, 'msg' => 'Check input is correct']);

            }else{
                return Response::json(['status' => 'error', 'data' => null, 'msg' => 'Current password is incorrect']);
            }
            
        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Password change failed !';
            return Response::json(['status' => 'error', 'data' => null, 'msg' => $msg]);
        }        

    }

}
