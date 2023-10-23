<?php
namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Activation;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Crypt;
use App\Common\Utils\AlertDataUtil;
//use Illuminate\Http\Request;
use App\Exceptions\CustomException;


class ActivationController extends Controller
{
    public function activate(string $encryptedEmail, string $activationCode){        
        try {
            
            $email = Crypt::decrypt($encryptedEmail);
            if($email === '')
                throw new CustomException("Invalid activation link");

            $user = UserModel::withoutGlobalScope('active')->whereEmail($email)->first();
            if(is_null($user))
                throw new CustomException("Invalid activation link");
            
            $isActivated = Activation::complete($user, $activationCode);            
            if(!$isActivated)
                abort(500, "Activation Failed due to server error !");

            return redirect('/login')
                ->with(AlertDataUtil::success('Now you can login',['msgTitle'=> 'Activation Complete!']));

        } catch (CustomException $e) {
            return redirect('/login')
                ->with(AlertDataUtil::error($e->getMessage(),['msgTitle'=> 'Activation Failed!']));

        }catch (\Exception $e) {
            return redirect('/login')->with(
                AlertDataUtil::error('Unable to activate your account. Please try again later.',[
                    'msgTitle'=> 'Activation Failed!'
                ])
            );    
        }
    }
    
}

