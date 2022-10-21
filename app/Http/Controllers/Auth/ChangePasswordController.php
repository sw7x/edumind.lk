<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Sentinel;


class ChangePasswordController extends Controller
{
    
    
    public function changePassword(Request $request) {
        return view ('auth.form-change-password');
    }


    public function postChangePassword(Request $request) {

        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'password_old'          =>'required|min:6|max:12',
            'password_new'          =>'required|min:6|max:12',
        ],[]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            try{
                $hasher = Sentinel::getHasher();

                $oldPassword    = $request->password_old;
                $password       = $request->password_new;

                //dd($password);
                //$passwordConf   = Input::get('password_confirmation');

                if($password==''){
                    throw new CustomException('invalid value for current password');
                }if($oldPassword==''){
                    throw new CustomException('invalid value for new password');
                }

                $user = Sentinel::getUser();
                if($user==null){
                    throw new CustomException('User does not exist in database');
                }


                //dd($user->password);
                //dd($hasher->check($oldPassword, $user->password));

                if ($hasher->check($oldPassword, $user->password)) {

                    Sentinel::update($user, array('password' => $password));
                    Session::flash('msgTitle', 'Success!');
                    Session::flash('message', 'Password successfully updated');
                    Session::flash('cls', 'flash-success');
                    return redirect()->route('auth.change-password', []);

                }else{
                    Session::flash('msgTitle', 'Error!');
                    Session::flash('message', 'Current password is incorrect');
                    Session::flash('cls', 'flash-danger');
                    return redirect()->back();
                }
            }catch(CustomException $e){

                Session::flash('msgTitle', 'Error!');
                Session::flash('message', $e->getMessage());
                Session::flash('cls', 'flash-danger');
                return redirect()->back();
            }catch(\Exception $e){

                Session::flash('msgTitle', 'Error!');
                //Session::flash('message', $e->getMessage());
                Session::flash('message', 'Error in registration process');
                Session::flash('cls', 'flash-danger');
                return redirect()->back();
            }
        }







    }

}
