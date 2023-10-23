<?php
namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Sentinel;
use App\Common\Utils\AlertDataUtil;


class ChangePasswordController extends Controller
{

    public function changePassword(Request $request) {
        //todo - need login
        return view ('auth.form-change-password');
    }


    public function postChangePassword(Request $request) {
        try{

            $validator = Validator::make($request->all(), [
                'password_old'          =>'required|min:6|max:12',
                'password_new'          =>'required|min:6|max:12',
            ],[]);

            if ($validator->fails())
                return back()->withErrors($validator,'changePw')->withInput();

            $hasher         = Sentinel::getHasher();
            $oldPassword    = $request->password_old;
            $password       = $request->password_new;

            if($password == '')
                throw new CustomException('invalid value for current password');

            if($oldPassword == '')
                throw new CustomException('invalid value for new password');

            $user = Sentinel::getUser();
            if(is_null($user))
                abort(401, 'You need to login before change your password');

            if (!$hasher->check($oldPassword, $user->password))
                return redirect()->back()->with(AlertDataUtil::error('Current password is incorrect'));

            Sentinel::update($user, array('password' => $password));
            
            return redirect()->route('auth.change-password', [])
                ->with(AlertDataUtil::success('Password successfully updated'));

        }catch(CustomException $e){
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Exception $e){
            return redirect()->back()->with(
                AlertDataUtil::error('Failed to change your password',[
                    //'message'   => $e->getMessage(),
                ])
            );
        }
    }

}
