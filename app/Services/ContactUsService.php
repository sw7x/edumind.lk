<?php
namespace App\Services;

use Sentinel;
use Illuminate\Http\Request;

use App\Repositories\ContactUsRepository;
use App\Common\Utils\RecaptchaUtil;
use App\Models\ContactUs as ContactUsModel;
class ContactUsService
{
    private ContactUsRepository $contactUsRepository;

    public function __construct(ContactUsRepository $contactUsRepository) {
        $this->contactUsRepository = $contactUsRepository;
    }


    public function saveContactUsMsg(Request $request) : ContactUsModel {
        $g_recaptcha_response = $request->input('g-recaptcha-response');
        $body = RecaptchaUtil::validate($g_recaptcha_response);

        if($body->success !== true)
            throw new CustomException('Recaptcha validation failed');

        $userid     = (isset($request->user_id)) ? $request->user_id : null;
        $full_name  = (isset($request->full_name)) ? $request->full_name : $request->full_name_hidden;
        $email      = (isset($request->email)) ? $request->email : null;
        $phone      = (isset($request->phone)) ? $request->phone : null;

        $contactInfoArr = array(
            'full_name' =>  $full_name,
            'email'     =>  $email,
            'phone'     =>  $phone,
            'subject'   =>  $request->subject,
            'message'   =>  $request->message,
            'user_id'   =>  $userid
        );

        return $this->contactUsRepository->create($contactInfoArr);
    }




}




//service only methods - not in entity
    //sumit msg




//methods - also in entity
