<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\resetPasswordMail;
use App\Models\User as UserModel;
use Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Sentinel;
use App\Common\Utils\AlertDataUtil;


//todo cant reset password editor,marketers,admin
class ForgotPasswordController extends Controller
{
    
    public function resetPasswordReq(){        
        if(Sentinel::check())
            return redirect(route('home'))->with(
                AlertDataUtil::warning('Logout first, then request reset password !')
            );

        return view ('auth.form-forget-password-request');
    }

    
    public function resetPasswordReqSubmit(Request $request){
        
        try {
            
            if(Sentinel::check())
                return redirect(route('home'))->with(
                    AlertDataUtil::warning('Logout first, then request reset password !')
                );

            $validator = Validator::make($request->all(), ['email' => 'required|email'],[
                'email.required'    => 'Email is required.',
                'email.email'       => 'must be emaill addresss'
            ]);

            if ($validator->fails())
                return back()->withErrors($validator,'forgotPw')->withInput();

            $user = UserModel::whereEmail($request->email)->first();
            
            if(is_null($user)){            
                $userRec = UserModel::withoutGlobalScope('active')->whereEmail($request->email)->first();          
                $msg     = ($userRec) ? 'Cant reset password because your account is disabled' : 'Invalid email.';
                return  redirect()->back()->with(AlertDataUtil::error($msg));
                
            }

            
            if(Reminder::exists($user)){
                // create new reminder if old reminder exists and it is created before 4 hours 
                $reminderModel  =   Reminder::createModel();
                $before4Hours   =   \Carbon\Carbon::now()->timezone('Asia/Colombo')->subHours(4)->toDateTimeString();
                $reminder       =   $reminderModel::where('user_id', '=', $user->id)
                                        ->where('updated_at', '>', $before4Hours)
                                        ->where('completed', 0)
                                        ->get()
                                        ->last();

                if($reminder == null)
                    $reminder = Reminder::create($user);

            }else{
                $reminder = Reminder::create($user);
            }
            
            //send mail
            $email          = $user->email;
            $encryptedEmail = Crypt::encrypt($email);
            $siteAddress    = url('/');
            $pwResetTxt     = "{$siteAddress}/reset/{$encryptedEmail}/{$reminder->code}";
            Mail::to($email)->send(new resetPasswordMail($pwResetTxt));

            return redirect()->back()->with(
                AlertDataUtil::success('Password reset link was sent to your email',[
                    //'title' => 'Student registration submit page'
                ])
            );            
            
        } catch (\Exception $e) {
            return redirect()->back()->with(
                AlertDataUtil::error('Failed to sent email which contains password reset link',[
                    //'title' => 'Student registration submit page'
                ])
            );     
        }

    }



    public function resetConfirm($encryptedEmail, $resetCode){
        try{
            
            if(Sentinel::check())
                return redirect(route('home'))->with(
                    AlertDataUtil::warning('Logout first, then confirm resetting password')
                );

            $email  =   Crypt::decrypt($encryptedEmail);
            $user   =   UserModel::whereEmail($email)->first();

            if(is_null($user)){
                $userRec     = UserModel::withoutGlobalScope('active')->whereEmail($email)->first();    
                $err_message = ($userRec) ? 'Cant reset password because your account is disabled' : 'Invalid email.';
                return  redirect(route('auth.reset-password-req-page'))
                            ->with(AlertDataUtil::error($err_message));   

            }

            $reminderModel  =   Reminder::createModel();
            $before4Hours   =   \Carbon\Carbon::now()->timezone('Asia/Colombo')->subHours(4)->toDateTimeString();
            $reminder       =   $reminderModel::where('user_id', '=', $user->id)
                                    ->where('updated_at', '>', $before4Hours)
                                    ->where('completed', 0)
                                    ->get()->last();
    
            if(Reminder::exists($user)){
                $code = $reminder->code;
                if($code == $resetCode){
                    return view('auth.form-forget-password-confirm');

                }else{
                    return redirect(route('auth.reset-password-req-page'))->with(
                        AlertDataUtil::error('Invalid reset password link')
                    );                                      
                }
            }else{
                return redirect(route('auth.reset-password-req-page'))->with(
                    AlertDataUtil::error('Invalid reset password link')
                );

            }

        }catch(\Exception $e){
            return redirect(route('auth.reset-password-req-page'))->with(
                AlertDataUtil::error('Error in reset password',[
                    //'message' => $e->getMessage(),
                ])
            );
        }
    }


    public function resetConfirmSubmit(Request $request, $encryptedEmail, $resetCode){
        try{
            
            if(Sentinel::check())
                return redirect(route('home'))->with(
                    AlertDataUtil::warning('Logout first, then confirm submit resetting password')
                );

            
            $validator = Validator::make($request->all(),[
                'password'              => 'confirmed|required|min:6|max:12',
                'password_confirmation' => 'required|min:6|max:12'
            ],[]);
            
            if ($validator->fails())
                return back()->withErrors($validator,'forgotPwConfirm')->withInput();

            $email  = Crypt::decrypt($encryptedEmail);
            $user   = UserModel::whereEmail($email)->first();

            if(is_null($user)){
                $userRec     = UserModel::withoutGlobalScope('active')->whereEmail($email)->first();    
                $err_message = ($userRec) ? 'Cant reset password because your account is disabled' : 'Invalid email.';
                session()->now('message', $err_message);
                session()->now('cls','flash-danger');
                session()->now('msgTitle','Error!');
                return view('acknowledgement');
            }

            if(Reminder::exists($user)){

                $reminderModel  =   Reminder::createModel();
                $before4Hours   =   \Carbon\Carbon::now()->timezone('Asia/Colombo')->subHours(4)->toDateTimeString();
                $reminder       =   $reminderModel::where('user_id', '=', $user->id)
                                        ->where('updated_at', '>', $before4Hours)
                                        ->where('completed', 0)
                                        ->get()
                                        ->last();
                $code           =   $reminder->code;

                if($code == $resetCode){
                    Reminder::complete($user, $code,$request->password);
                    return redirect()->route('auth.login')->with(
                        AlertDataUtil::success('Please login with your new password',[
                            'message2'  => 'Successfully password reset was done!'
                        ])
                    );

                }else{
                    return redirect()->route('auth.reset-password-req-page')->with(
                        AlertDataUtil::error('Invalid reset password link')
                    ); 
                }
            }else{
                return redirect()->route('auth.reset-password-req-page')->with(
                    AlertDataUtil::error('Invalid reset password link')
                );              
            }

        }catch(\Exception $e){
            return redirect()->back()->with(
                AlertDataUtil::error('Error in reset password',[
                    //'message'  => $e->getMessage(),
                ])
            );
        }

    }

}
