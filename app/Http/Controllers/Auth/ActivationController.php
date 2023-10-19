<?php
namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Activation;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Crypt;
use App\Common\Utils\AlertDataUtil;

//use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function activate($encryptedEmail, $activationCode){
        
        try {
            
            $email  =   Crypt::decrypt($encryptedEmail);
            $user   =   UserModel::withoutGlobalScope('active')->whereEmail($email)->first();

            if(Activation::complete($user,$activationCode)){
                return redirect('/login')->with(
                    AlertDataUtil::success('Now you can login',[
                        'msgTitle'=> 'Activation Complete!'
                    ])
                );

            }else{
                throw new \Exception("Activation Failed!");                
            }  

        } catch (\Throwable $e) {
            return redirect('/login')->with(
                AlertDataUtil::error('Unable to activate your account. Please try again later.',[
                    'msgTitle'=> 'Activation Failed!'
                ])
            );    
        }



    }
}

