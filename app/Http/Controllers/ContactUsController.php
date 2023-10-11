<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Sentinel;
use App\Services\ContactUsService;
use App\Exceptions\CustomException;
use App\Models\Role as RoleModel;
use App\Models\ContactUs as ContactUsModel;

//use GuzzleHttp\Client;
//use Illuminate\Validation\ValidationException;
//use App\Utils\RecaptchaUtil;

class ContactUsController extends Controller
{

    private ContactUsService $contactUsService;

    public function __construct(ContactUsService $contactUsService){
        $this->contactUsService = $contactUsService;

        /*
        todo
        $this->middleware('check.admin',
            ['only' => ['store','update','destroy']]
        );
        */
    }



    public function viewPage(){
        if(Sentinel::check()){
            $user            = Sentinel::getUser();
            $currentUserRole = optional($user->roles()->first())->name;
            if($currentUserRole == RoleModel::ADMIN)
                abort(404,'This page is not available for your user role');
        }

        $userArr = $this->contactUsService->getUserInfoArr();
        return view('contact')->with('userArr', $userArr);
    }


    public function submitForm(Request $request){

        try{
            $validator = Validator::make($request->all(), [
                'full_name'             =>'sometimes|required',
                'subject'               =>'required|min:3|max:50',
                'message'               =>'required',
                'g-recaptcha-response'  =>'required',
            ],[
                'full_name.required'            => 'Full name field is required.',

                'subject.required'              => 'Subject field is required.',
                'subject.min'                   => 'Subject should have minimum 3 characters.',
                'subject.max'                   => 'Subject should not exceed 50 characters.',

                'message.required'              => 'Message field is required.',
                'g-recaptcha-response.required' => 'Recaptcha is required.',
            ]);

            if ($validator->fails())
                throw new CustomException('Form validation failed');

            $this->authorize('create', ContactUsModel::class);

            $insertedRec = $this->contactUsService->saveContactUsMsg($request);
            if(!$insertedRec)
                throw new CustomException('Failed to insert into database');

            return redirect()->back()->with([
                'message'  => 'Your message has been sent successfully',
                'cls'      => 'flash-success',
                'msgTitle' => 'Success',
            ]);

        }catch(CustomException $e){
            return back()
            ->withErrors($validator)
            ->withInput()
            ->with([
                'message'   => $e->getMessage(),
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error!'
            ]);

        }catch(\Exception $e){
            return back()
            ->withErrors($validator)
            ->withInput()
            ->with([
                'message'   => $e->getMessage(),
                //'message'     => 'Form submit failed',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error!'
            ]);
        }


    }


}

