<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Sentinel;

//use Illuminate\Support\Facades\Response;

class ChangePasswordController extends Controller
{


    public function changePassword(Request $request) {
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
                throw new CustomException('User does not exist in database');
            
            if ($hasher->check($oldPassword, $user->password)) {
                Sentinel::update($user, array('password' => $password));
                return redirect()->route('auth.change-password', [])->with([
                    'msgTitle'  => 'Success!',
                    'message'   => 'Password successfully updated',
                    'cls'       =>'flash-success'
                ]);

            }else{
               return redirect()->back()->with([
                    'msgTitle'  => 'Error!',
                    'message'   => 'Current password is incorrect',
                    'cls'       => 'flash-danger'
                ]);
            }

        }catch(CustomException $e){
            return redirect()->back()->with([
                'msgTitle'  => 'Error!',
                'message'   => $e->getMessage(),
                'cls'       => 'flash-danger'
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with([
                'msgTitle'  => 'Error!',
                'message'   => 'Failed to change your password',
                //'message'   => $e->getMessage(),                    
                'cls'       => 'flash-danger'
            ]);

        }
        
    }

}
