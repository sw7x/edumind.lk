<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\resetPasswordMail;
use App\Models\User;
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

        $user = User::whereEmail($request->email)->first();

        if($user==null){
           return redirect()->back()->with([
               'message'  => 'Invalid email.',
               'cls'     => 'flash-danger',
               'msgTitle'=> 'Error!',
           ]);
        }else{

            if(Reminder::exists($user)){

                $reminderModel = Reminder::createModel();
                $before4Hours  = \Carbon\Carbon::now()->timezone('Asia/Colombo')->subHours(4)->toDateTimeString();
                $reminder = $reminderModel::where('user_id', '=', $user->id)
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

            $siteAddress = url('/');
            $pwResetTxt = "{$siteAddress}/reset/{$encryptedEmail}/{$reminder->code}";
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
            $email = Crypt::decrypt($encryptedEmail);
            $user = User::whereEmail($email)->first();

            $reminderModel = Reminder::createModel();
            $before4Hours  = \Carbon\Carbon::now()->timezone('Asia/Colombo')->subHours(4)->toDateTimeString();
            $reminder = $reminderModel::where('user_id', '=', $user->id)
                ->where('updated_at', '>', $before4Hours)
                ->where('completed', 0)
                ->get()->last();

            $code = $reminder->code;

            if($user == null){
                return view('form-submit-page')->with([
                    'message' => 'Invalid user',
                    'title'   => 'Reset password page',
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ]);
            }

            if(Reminder::exists($user)){

                if($code == $resetCode){
                    //return 'ok';
                    return view('auth.form-reset-password')->with([
                        'message' => 'Valid reset password link',
                        'title'   => 'Reset password page',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success!',
                    ]);

                }else{
                    return view('form-submit-page')->with([
                        'message' => 'Invalid reset password link',
                        'title'   => 'Reset password page',
                        'cls'     => 'flash-danger',
                        'msgTitle'=> 'Error!',
                    ]);
                }
            }else{
                return view('form-submit-page')->with([
                    'message' => 'Invalid reset password link',
                    'title'   => 'Reset password page',
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ]);
            }

        }catch(\Exception $e){
            return view('form-submit-page')->with([
                //'message' => 'Error in reset password',
                'message' => $e->getMessage(),
                'title'   => 'Reset password page',
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error!',
            ]);
        }
    }

    public function postResetPassword(Request $request,$encryptedEmail,$resetCode){

        $this->validate($request,[
            'password'              => 'confirmed|required|min:6|max:12',
            'password_confirmation' => 'required|min:6|max:12',
        ]);

        try{
            $email = Crypt::decrypt($encryptedEmail);
            $user = User::whereEmail($email)->first();

            if($user == null){
                return view('form-submit-page')->with([
                    'message' => 'Invalid user',
                    'title'   => 'Reset password page',
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ]);
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
                    return view('form-submit-page')->with([
                        'message' => 'Invalid reset password link',
                        'title'   => 'Reset password page',
                        'cls'     => 'flash-danger',
                        'msgTitle'=> 'Error!',
                    ]);
                }
            }else{
                return view('form-submit-page')->with([
                    'message' => 'Invalid reset password link',
                    'title'   => 'Reset password page',
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ]);
            }

        }catch(\Exception $e){
            return view('form-submit-page')->with([
                'message' => 'Error in reset password',
                //'message' => $e->getMessage(),
                'title'   => 'Reset password page',
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error!',
            ]);
        }

    }

}
