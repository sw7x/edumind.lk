<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\resetPasswordMail;
use App\Models\User as UserModel;
use Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;



//todo cant reset password editor,marketers,admin
class ForgotPasswordController extends Controller
{
    public function forgotPassword(){
        return view ('auth.form-forget-password');
    }

    public function postForgotPassword(Request $request){

        $user = UserModel::whereEmail($request->email)->first();

        if($user==null){
            
            $userRec = UserModel::withoutGlobalScope('active')->whereEmail($request->email)->first();          
            return redirect()->back()->with([
               'message' => ($userRec) ? 'Cant reset password because your account is disabled' : 'Invalid email.',
               'cls'     => 'flash-danger',
               'msgTitle'=> 'Error!',
           ]);
        }else{

            if(Reminder::exists($user)){

                $reminderModel  =   Reminder::createModel();
                $before4Hours   =   \Carbon\Carbon::now()->timezone('Asia/Colombo')->subHours(4)->toDateTimeString();
                $reminder       =   reminderModel::where('user_id', '=', $user->id)
                                        ->where('updated_at', '>', $before4Hours)
                                        ->where('completed', 0)
                                        ->get()->last();

                if($reminder == null)
                    $reminder = Reminder::create($user);

            }else{
                $reminder = Reminder::create($user);
            }

            $email          = $user->email;
            $encryptedEmail = Crypt::encrypt($email);

            $siteAddress    = url('/');
            $pwResetTxt     = "{$siteAddress}/reset/{$encryptedEmail}/{$reminder->code}";
            //send mail
            Mail::to($email)->send(new resetPasswordMail($pwResetTxt));

            return redirect()->back()->with([
               'message' => 'Password reset link was sent to your email',
               //'title'   => 'Student registration submit page',
               'cls'     => 'flash-success',
               'msgTitle'=> 'Success!',
            ]);
        }
    }



    public function resetPassword($encryptedEmail,$resetCode){

        try{
            $email  =   Crypt::decrypt($encryptedEmail);
            $user   =   UserModel::whereEmail($email)->first();

            $reminderModel  =   Reminder::createModel();
            $before4Hours   =   \Carbon\Carbon::now()->timezone('Asia/Colombo')->subHours(4)->toDateTimeString();
            $reminder       =   $reminderModel::where('user_id', '=', $user->id)
                                    ->where('updated_at', '>', $before4Hours)
                                    ->where('completed', 0)
                                    ->get()->last();

            $code = $reminder->code;

            if($user == null){
                $userRec     = UserModel::withoutGlobalScope('active')->whereEmail($email)->first();    
                $err_message = ($userRec) ? 'Cant reset password because your account is disabled' : 'Invalid email.';
                
                session()->flash('message',$err_message);
                session()->flash('cls','flash-danger');
                session()->flash('msgTitle','Error!');
                return view('form-submit-page');
            }

            if(Reminder::exists($user)){

                if($code == $resetCode){
                    //return 'ok';
                    session()->flash('message','Valid reset password link');
                    session()->flash('cls','flash-success');
                    session()->flash('msgTitle','Success!');
                    return view('auth.form-reset-password');

                }else{
                    session()->flash('message','Invalid reset password link');
                    session()->flash('cls','flash-danger');
                    session()->flash('msgTitle','Error!');
                    return view('form-submit-page');
                    
                }
            }else{
                session()->flash('message','Invalid reset password link');
                session()->flash('cls','flash-danger');
                session()->flash('msgTitle','Error!');
                return view('form-submit-page');

            }

        }catch(\Exception $e){
            session()->flash('message', 'Error in reset password');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('form-submit-page');

        }
    }

    public function postResetPassword(Request $request,$encryptedEmail,$resetCode){

        $this->validate($request,[
            'password'              => 'confirmed|required|min:6|max:12',
            'password_confirmation' => 'required|min:6|max:12',
        ]);

        try{
            $email = Crypt::decrypt($encryptedEmail);
            $user = UserModel::whereEmail($email)->first();

            if($user == null){
                $userRec     = UserModel::withoutGlobalScope('active')->whereEmail($email)->first();    
                $err_message = ($userRec) ? 'Cant reset password because your account is disabled' : 'Invalid email.';
                
                session()->flash('message',$err_message);
                //session()->flash('message', 'Invalid user');
                session()->flash('cls','flash-danger');
                session()->flash('msgTitle','Error!');
                return view('form-submit-page');
            }

            if(Reminder::exists($user)){

                $reminderModel = Reminder::createModel();
                $before4Hours  = \Carbon\Carbon::now()->timezone('Asia/Colombo')->subHours(4)->toDateTimeString();
                $reminder = $reminderModel::where('user_id', '=', $user->id)
                    ->where('updated_at', '>', $before4Hours)
                    ->where('completed', 0)
                    ->get()->last();
                $code = $reminder->code;

                if($code == $resetCode){

                    Reminder::complete($user, $code,$request->password);
                    return redirect()->route('auth.login')->with([
                        'message' => 'Please login with your new password',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success!',
                        'message2'=> 'Successfully password reset was done!',
                    ]);

                }else{
                    session()->flash('message', 'Invalid reset password link');
                    session()->flash('cls','flash-danger');
                    session()->flash('msgTitle','Error!');
                    return view('form-submit-page');
                }
            }else{
                session()->flash('message', 'Invalid reset password link');
                session()->flash('cls','flash-danger');
                session()->flash('msgTitle','Error!');
                return view('form-submit-page');                

            }

        }catch(\Exception $e){
            session()->flash('message', 'Error in reset password');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('form-submit-page');
            
        }

    }

}
