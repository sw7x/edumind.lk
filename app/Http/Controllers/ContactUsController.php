<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Sentinel;
use App\Services\ContactUsService;
use App\Exceptions\CustomException;
use App\Models\Role as RoleModel;
use App\Models\ContactUs as ContactUsModel;
use App\Common\SharedServices\UserSharedService;
//use GuzzleHttp\Client;
//use Illuminate\Validation\ValidationException;
//use App\Common\Utils\RecaptchaUtil;
use App\Http\Requests\ContactUsFormRequest;
use Illuminate\Support\Facades\Session;


class ContactUsController extends Controller
{

    private ContactUsService $contactUsService;

    public function __construct(ContactUsService $contactUsService){
        $this->contactUsService = $contactUsService;
                $this->middleware('auth');

        //$this->middleware('withOutUserRoles:RoleModel::ADMIN');
    }



    public function viewContactUs(){
        $user    = Sentinel::getUser();        
        $userArr = (new UserSharedService)->getUserInfoArr($user);
        return view('contact')->with('userArr', $userArr);
    }


    public function submitContactForm(ContactUsFormRequest $request){

        try{
                        
            $formErrors = optional(Session::get('errors'))->contactUsForm;
            if ( isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation is failed !');

            $this->authorize('create', ContactUsModel::class);

            $insertedRec = $this->contactUsService->saveContactUsMsg($request);
            if(!$insertedRec)
                throw new CustomException('Failed to save your message in database');

            return redirect()->back()->with([
                'message'  => 'Your message has been sent successfully',
                'cls'      => 'flash-success',
                'msgTitle' => 'Success',
            ]);

        }catch(CustomException $e){
            return back()
            ->withErrors($formErrors)
            ->withInput()
            ->with([
                'message'   => $e->getMessage(),
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error!'
            ]);

        }catch(\Exception $e){
            return back()
            ->withErrors($formErrors)
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

