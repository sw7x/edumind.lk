<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Activation;
use Illuminate\Http\Request;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Crypt;


class ActivationController extends Controller
{
    public function activate($encryptedEmail, $activationCode){
        $email  =   Crypt::decrypt($encryptedEmail);
        $user   =   UserModel::withoutGlobalScope('active')->whereEmail($email)->first();


        if(Activation::complete($user,$activationCode)){
            return redirect('/login')->with([
                'message' => 'Now you can login',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Activation Complete!',
            ]);

        }else{

            //todo
        }
    }
}
