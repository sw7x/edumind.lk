<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\TeacherRegMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Sentinel;
use Activation;
use App\Mail\StudentRegMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Utils\FileUploadUtil;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use App\Models\User as UserModel;
use App\Exceptions\CustomException;
use App\Models\Role as RoleModel;

//use Swift_TransportException;

class RegistrationController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkGuest',
            ['only' => ['register','teacherRegister']]
        );
    }

    public function register(){
       return view ('auth.form-register');
    }


    public function postRegister(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'full_name'             =>'required|min:3|max:100|unique:users,full_name',
                'email'                 =>'required|email|unique:users,email',
                'username'              =>'nullable|sometimes|unique:users,username',
                'password'              =>'required|min:6|max:12',
                'phone'                 =>'required|unique:users,phone',
                'gender'                =>'required',
                'g-recaptcha-response'  =>'required',
                'dob_year'              =>'required|digits:4|integer|min:'.(date('Y')-100).'|max:'.date('Y'),
            ],[
                'full_name.unique'              => 'This full name is already been used',
                'email.unique'                  => 'This Email is already been used',
                'phone.unique'                  => 'This phone number is already been used',
                'message.required'              => 'Message field is required.',
                'g-recaptcha-response.required' => 'Recaptcha is required.',
                'dob_year.digits'               => 'Date of birth year format is invalid.',
            ]);

            if ($validator->fails())
                return back()->withErrors($validator,'studentReg')->withInput();

            if($request->input('username') == null){            
                //if username empty then username = email
                $username   = strstr($request->input('email'),'@',true);

                // check username alredy used in DB
                $unameCount =   UserModel::withoutGlobalScope('active')->where('username', '=', $username)->count();
                if ($unameCount > 0)
                    throw new CustomException("username - {$username} not available to use");

                $request->merge(['username'  =>  $username]);
            }
            
            // validate recaptcha
            $client = new Client;
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',[
                    'form_params' =>    [
                            'secret'    => config('services.recaptcha.secret-key'),
                            'response'  => $request->input('g-recaptcha-response')
                        ]
                ]
            );
            $body = json_decode((string)$response->getBody());

            if($body->success){

                //throw new \Exception("error sending student");
                $user       = Sentinel::register($request->all());
                $activation = Activation::create($user);

                $role = Sentinel::findRoleBySlug(RoleModel::STUDENT);
                $role->users()->attach($user);

                //send mail
                $email          = $user->email;
                $encryptedEmail = Crypt::encrypt($email);
                $activationCode = $activation->code;
                $siteAddress    = url('/');
                $link           = "{$siteAddress}/activate/{$encryptedEmail}/{$activationCode}";
                $username       = $request->input('username');
                Mail::to($email)->send(new StudentRegMail($link,$username));

                return view('form-submit-page')->with([
                    'message'   => 'Successfully registered, check you emails to use account activation link',
                    'cls'       => 'flash-success',
                    'msgTitle'  => 'Success!'
                ]);

            }else{
                return back()->with([
                    'message'     => 'Recaptcha validation failed',
                    'cls'         => 'flash-danger',
                    'msgTitle'    => 'Form submit error !'
                ]);
            }

        }catch(CustomException $e){
            return redirect()->back()->with([
                'message'   => $e->getMessage(),
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error!'
            ]);

        }catch(\Exception $e){
            //return redirect()->route('auth.register');
            return redirect()->back()->with([
                'message'   => 'Error in registration process',
                //'message' => $e->getMessage(),
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error!'
            ]);                
            
        }
        

    }


    public function teacherRegister(Request $request){
        return view ('auth.form-teacher-register');
    }


    public function postTeacherRegister(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'full_name'             =>'required|min:3|max:100|unique:users,full_name',
                'email'                 =>'required|email|unique:users,email',
                'username'              =>'nullable|sometimes|unique:users,username',
                'password'              =>'required|min:6|max:12',
                'phone'                 =>'required|unique:users,phone',
                'gender'                =>'required',
                'g-recaptcha-response'  =>'required',
                'dob_year'              =>'required|digits:4|integer|min:'.(date('Y')-100).'|max:'.date('Y'),
            ],[
                'full_name.required'            => 'Full name field is required.',
                'full_name.unique'              => 'This full name is already been used',
                'email.unique'                  => 'This Email is already been used',
                'phone.unique'                  => 'This phone number is already been used',
                'message.required'              => 'Message field is required.',
                'g-recaptcha-response.required' => 'Recaptcha is required.',
                'dob_year.digits'               => 'Date of birth year format is invalid.',
            ]);            

            if ($validator->fails())
                return back()->withErrors($validator, 'teacherReg')->withInput();

            if($request->input('username') == null){
                //if username empty then username = email
                $username = strstr($request->input('email'),'@',true);

                // check username alredy used in DB
                $unameCount =   UserModel::withoutGlobalScope('active')->where('username', '=', $username)->count();
                if ($unameCount > 0)
                    throw new CustomException("username - {$username} not available to use");

                $request->merge(['username'  =>  $username]);
            }

            // validate recaptcha
            $client = new Client;
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',[
                    'form_params' =>    [
                            'secret'    => config('services.recaptcha.secret-key'),
                            'response'  => $request->input('g-recaptcha-response')
                        ]
                ]
            );
            $body = json_decode((string)$response->getBody());

            // recaptcha validate success
            if($body->success){

                $file = $request->input('profile_pic');
                $destination = isset($file) ? (new FileUploadUtil())->upload($file,'users/teachers/') : null;

                $reqData = $request->all();
                $reqData['profile_pic'] = $destination;

                $user = Sentinel::register($reqData);
                //$user = Sentinel::register($request->all());

                $activation = Activation::create($user);

                $role = Sentinel::findRoleBySlug(RoleModel::TEACHER);
                $role->users()->attach($user);

                //send mail
                $email          = $user->email;
                $encryptedEmail = Crypt::encrypt($email);
                $activationCode = $activation->code;
                $siteAddress    = url('/');
                $link           = "{$siteAddress}/activate/{$encryptedEmail}/{$activationCode}";
                $username       = $request->input('username');
                Mail::to($email)->send(new TeacherRegMail($link,$username));

                return view('form-submit-page')->with([
                    'message'  => 'Successfully registered, check you emails to use account activation link',
                    'title'    => 'Teacher registration submit page',
                    'cls'      => 'flash-success',
                    'msgTitle' => 'Success!',
                ]);

            }else{
                return back()->with([
                    'message'   => 'Recaptcha validation failed',
                    'cls'       => 'flash-danger',
                    'msgTitle'  => 'Form submit error !',
                ]);
            }

        }catch(CustomException $e){
            if(isset($destination) && ($destination != false))
                Storage::disk('public')->delete($destination);
            
            return redirect()->back()->with([
                'message'   => $e->getMessage(),
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error!'
            ]);

        }catch(\Exception $e){
            if(isset($destination) && ($destination != false))
                Storage::disk('public')->delete($destination);
            
            //return redirect()->route('auth.register');
            return redirect()->back()->with([
                //'message'   => $e->getMessage(),
                'message'   => 'Error in registration process',
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error!'
            ]);

        }
        

    }


}
