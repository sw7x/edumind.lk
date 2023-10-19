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
use App\Common\Utils\AlertDataUtil;


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
            
            return redirect()->back()->with(AlertDataUtil::success('Your message has been sent successfully'));

        }catch(CustomException $e){
            return back()
            ->withErrors($formErrors)
            ->withInput()
            ->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Exception $e){
            return back()
            ->withErrors($formErrors)
            ->withInput()
            ->with(AlertDataUtil::error('Form submit failed',['message'=> $e->getMessage()]));
        }


    }


}

