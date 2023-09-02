<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
//use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Sentinel;
use App\Utils\RecaptchaUtil;

use App\Services\ContactUsService;



class ContactUsController extends Controller
{

    private $contactUsService;

    public function __construct(ContactUsService $contactUsService)
    {
        $this->contactUsService = $contactUsService;

        /*
        todo
        $this->middleware('check.admin',
            ['only' => ['store','update','destroy']]
        );

        */

    }



    public function index(){

        $user = Sentinel::getUser();

        if($user){
            $userArr = [
                'id'        => $user->id,
                'full_name' => $user->full_name,
                'email'     => $user->email,
                'phone'     => $user->phone,
            ];
        }else{
            $userArr = [];
        }

        //dd(isset($userArr['email']));
        return view('contact')->with('userArr',$userArr);
    }


    public function store(Request $request){

        //dd($request->all());
        //dd($request->input('full_name'));

        $g_recaptcha_response = $request->input('g-recaptcha-response');
        //dd($g_recaptcha_response);

        $validator = Validator::make($request->all(), [
            'full_name'             =>'sometimes|required',
            'subject'               =>'required|min:3|max:50',
            'message'               =>'required',
            'g-recaptcha-response'  =>'required',
        ],[
            'full_name.required'            => 'Full name field is required.',
            'subject.required'              => 'Subject field is required.',
            'message.required'              => 'Message field is required.',
            'g-recaptcha-response.required' => 'Recaptcha is required.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            // validate recaptcha
            $body = RecaptchaUtil::validate($g_recaptcha_response);
            
            if($body->success){

                $userid     = (isset($request->user_id))?$request->user_id:null;
                $full_name  = (isset($request->full_name))?$request->full_name:$request->full_name_hidden;
                $email      = (isset($request->email))?$request->email:null;
                $phone      = (isset($request->phone))?$request->phone:null;

                $this->contactUsService->add([
                    'full_name'     =>  $full_name,
                    'email'         =>  $email,
                    'phone'         =>  $phone,
                    'subject'       =>  $request->subject,
                    'message'       =>  $request->message,
                    'user_id'        => $userid
                ]);                

                return redirect()->back()->with([
                    'message' => 'Your message has been sent successfully',
                    'cls'     => 'flash-success',
                    'msgTitle'=> 'Success',
                ]);

            }else{
                // return with error msg
                return back()->with([
                    'message'     => 'Recaptcha validation failed',
                    'cls'         => 'flash-danger',
                    'msgTitle'    => 'Form submit error !'
                ]);
            }

        }

    }


}
