<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Sentinel;


class ChangeAdminPasswordController extends Controller
{
    
    public function changePassword(Request $request) {
        //dd($request->all());
        $response = array();
        try{
            $hasher = Sentinel::getHasher();

            $oldPassword    = $request->old_password;
            $password       = $request->password;

            //dd($password);
            //$passwordConf   = Input::get('password_confirmation');

            if($password==''){
                throw new CustomException('invalid value for current password');
            }
            if($oldPassword==''){
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
                $response['status'] = 'success';
                $response['data'] = null;
                $response['msg'] = 'Check input is correct';
                return Response::json( $response );

            }else{
                $response['status'] = 'error';
                $response['data'] = null;
                $response['msg'] = 'Current password is incorrect';
                return Response::json( $response );
            }
        }catch(CustomException $e){

            $response['status'] = 'error';
            $response['data'] = null;
            $response['msg'] = $e->getMessage();
            return Response::json( $response );

        }catch(\Exception $e){

            $response['status'] = 'error';
            $response['data'] = null;
            //$response['msg'] = 'Error cannot change password';
            $response['msg'] = $e->getMessage();
            return Response::json( $response );
        }




        //return Redirect::to('/');
    }

}
