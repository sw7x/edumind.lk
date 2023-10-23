<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Sentinel;
use App\Exceptions\CustomException;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class AuthService
{  

    private UserRepository $userRepository;

    function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
    

    public function generateUsername(Request $request) : string {        
        //if username empty then username = email
        $username = strstr($request->input('email'),'@',true);

        // check username alredy used in DB
        $unameCount = $this->userRepository->findUserCountByUsername($username);
        if ($unameCount > 0)
            throw new CustomException("username - {$username} not available to use");

        return $username;        
    }


    public function createActivationLink(UserModel $user, string $activationCode) : string {      
        $email          = $user->email;
        $encryptedEmail = Crypt::encrypt($email);        
        $siteAddress    = url('/');
        $link           = "{$siteAddress}/activate/{$encryptedEmail}/{$activationCode}";
        return $link;
    }

    public function createForgotPasswordLink(UserModel $user, string $code) : string {      
        $email          = $user->email;
        $encryptedEmail = Crypt::encrypt($email);        
        $siteAddress    = url('/');
        $link           = "{$siteAddress}/reset/{$encryptedEmail}/{$code}";
        return $link;
    }
        

    
}


