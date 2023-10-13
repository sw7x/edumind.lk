<?php
namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Activation;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Crypt;

//use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function activate($encryptedEmail, $activationCode){
        
        try {
            
            $email  =   Crypt::decrypt($encryptedEmail);
            $user   =   UserModel::withoutGlobalScope('active')->whereEmail($email)->first();

            if(Activation::complete($user,$activationCode)){
                return redirect('/login')->with([
                    'message' => 'Now you can login',
                    'cls'     => 'flash-success',
                    'msgTitle'=> 'Activation Complete!',
                ]);

            }else{
                throw new \Exception("Activation Failed!");                
            }  

        } catch (\Throwable $e) {
            return redirect('/login')->with([
                'message' => 'Unable to activate your account. Please try again later.',
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Activation Failed!',
            ]);    
        }



    }
}
