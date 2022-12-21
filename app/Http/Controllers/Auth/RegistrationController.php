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
//use Swift_TransportException;
use App\Utils\FileUploadUtil;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use App\Models\User;
use App\Exceptions\CustomException;





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
        
        
        //if username empty then username = email
        $g_recaptcha_response = $request->input('g-recaptcha-response');        

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

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            try {                
                
                if($request->input('username') == null){
                    $username = strstr($request->input('email'),'@',true);
                    
                    // username alredy used in DB
                    if (User::where('username', '=', $username)->count() > 0) {                   
                        throw new CustomException("username - {$username} not available to use");
                    }                
                }

                // validate recaptcha
                $client = new Client;
                $response = $client->post(
                    'https://www.google.com/recaptcha/api/siteverify',[
                        'form_params' =>    [
                                'secret' => config('services.recaptcha.secret-key'),
                                'response' => $g_recaptcha_response
                            ]
                    ]
                );
                $body = json_decode((string)$response->getBody());

                if($body->success){
                    
                    //throw new \Exception("error sending student");
                    $user = Sentinel::register($request->all());
                    $activation = Activation::create($user);

                    $role = Sentinel::findRoleBySlug('student');
                    $role->users()->attach($user);

                    //dd($user->email);
                    $email = $user->email;
                    $encryptedEmail = Crypt::encrypt($email);
                    $activationCode = $activation->code;
                    $siteAddress = url('/');
                    $link = "{$siteAddress}/activate/{$encryptedEmail}/{$activationCode}";
                    $username = $request->input('username');
                    //send mail
                    Mail::to($email)->send(new StudentRegMail($link,$username));

                    session()->flash('message', 'Successfully registered, check you emails to use account activation link');
                    session()->flash('cls','flash-success');
                    session()->flash('msgTitle','Success!');
                    return view('form-submit-page');                    

                }else{
                    return back()->with([
                        'message'     => 'Recaptcha validation failed',
                        'cls'         => 'flash-danger',
                        'msgTitle'    => 'Form submit error !',

                    ]);
                }

            }catch(CustomException $e){

                Session::flash('msgTitle', 'Error!');
                Session::flash('message', $e->getMessage());
                Session::flash('cls', 'flash-danger');
                return redirect()->back();
            }catch(\Exception $e){

                Session::flash('msgTitle', 'Error!');
                //Session::flash('message', $e->getMessage());
                Session::flash('message', 'Error in registration process');
                Session::flash('cls', 'flash-danger');
                //return redirect()->route('auth.register');
                return redirect()->back();
            }
        }        

    }


    public function teacherRegister(Request $request){
        return view ('auth.form-teacher-register');
    }


    public function postTeacherRegister(Request $request){
        
        $g_recaptcha_response = $request->input('g-recaptcha-response');        

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

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            try {                
                
                if($request->input('username') == null){
                    $username = strstr($request->input('email'),'@',true);
                    
                    // username alredy used in DB
                    if (User::where('username', '=', $username)->count() > 0) {                   
                        throw new CustomException("username - {$username} not available to use");
                    }                
                }

                // validate recaptcha
                $client = new Client;
                $response = $client->post(
                    'https://www.google.com/recaptcha/api/siteverify',[
                        'form_params' =>    [
                                'secret' => config('services.recaptcha.secret-key'),
                                'response' => $g_recaptcha_response
                            ]
                    ]
                );
                $body = json_decode((string)$response->getBody());

                // recaptcha validate success 
                if($body->success){                    
                    
                    $file = $request->input('profile_pic');
            
                    if(isset($file)){
                        $fileUploadUtil = new FileUploadUtil();
                        $destination    = $fileUploadUtil->upload($file,'users/teachers/');
                    }else{
                        $destination = null;
                    }


                    $reqData = $request->all();
                    $reqData['profile_pic'] = $destination;

                    $user = Sentinel::register($reqData);
                    //$user = Sentinel::register($request->all());


                    $activation = Activation::create($user);

                    $role = Sentinel::findRoleBySlug('teacher');
                    $role->users()->attach($user);


                    $email = $user->email;
                    $encryptedEmail = Crypt::encrypt($email);
                    $activationCode = $activation->code;
                    $siteAddress = url('/');
                    $link = "{$siteAddress}/activate/{$encryptedEmail}/{$activationCode}";
                    $username = $request->input('username');
                    
                    //send mail
                    Mail::to($email)->send(new TeacherRegMail($link,$username));

                    return view('form-submit-page')->with([
                        'message' => 'Successfully registered, check you emails to use account activation link',
                        'title'   => 'Teacher registration submit page',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success!',
                    ]);


                }else{
                    return back()->with([
                        'message'     => 'Recaptcha validation failed',
                        'cls'         => 'flash-danger',
                        'msgTitle'    => 'Form submit error !',

                    ]);
                }

            }catch(CustomException $e){

                if(isset($destination) && ($destination != false)){
                    Storage::disk('public')->delete($destination);
                }                
                Session::flash('msgTitle', 'Error!');
                Session::flash('message', $e->getMessage());
                Session::flash('cls', 'flash-danger');
                return redirect()->back();

            }catch(\Exception $e){
                
                if(isset($destination) && ($destination != false)){
                    Storage::disk('public')->delete($destination);
                }

                //dd($e->getMessage());
                Session::flash('msgTitle', 'Error!');
                //Session::flash('message', $e->getMessage());
                Session::flash('message', 'Error in registration process');
                Session::flash('cls', 'flash-danger');
                //return redirect()->route('auth.register');
                return redirect()->back();
            }
        }       

    }


}
