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
use App\Common\Utils\FileUploadUtil;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\CustomException;
use App\Models\Role as RoleModel;
use App\Common\Utils\AlertDataUtil;
use App\Common\Utils\RecaptchaUtil;
use App\Http\Requests\StudentRegisterRequest;
use App\Http\Requests\TeacherRegisterRequest;
use App\Services\AuthService;

use App\Permissions\Abilities\AuthAbilities;
use App\Permissions\PermissionChecker;


class RegistrationController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;    
    }

    public function register(){
        PermissionChecker::authorizeGate(AuthAbilities::STUDENT_REGISTER);
        return view ('auth.form-register');
    }

    public function postRegister(StudentRegisterRequest $request){
        PermissionChecker::authorizeGate(AuthAbilities::STUDENT_REGISTER);
        
        try {

            $formErrors = optional(Session::get('errors'))->studentReg;
            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation is failed');

            if($request->input('username') == null){
                $username = $this->authService->generateUsername($request);
                $request->merge(['username' => $username]);
            }

            // validate recaptcha
            $body = RecaptchaUtil::validate($request->input('g-recaptcha-response'));
            if(!$body->success)
                return back()->with(AlertDataUtil::error('Recaptcha validation failed'));

            //register, activate and assign role for the account
            $user       = Sentinel::register($request->all());
            $activation = Activation::create($user);
            $role       = Sentinel::findRoleBySlug(RoleModel::STUDENT);
            $role->users()->attach($user);

            //send mail
            $email          = $user->email;
            $username       = $request->input('username');
            $activationLink = $this->authService->createActivationLink($user, $activation->code);
            Mail::to($email)->send(new StudentRegMail($activationLink, $username));

            return view('form-submit-page')->with(
                AlertDataUtil::success('Successfully registered, check you emails to use account activation link')
            );

        }catch(CustomException $e){
            return redirect()->back()
                ->withErrors($formErrors)
                ->withInput()
                ->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Exception $e){
            //return redirect()->route('auth.register');
            return redirect()->back()
                ->withErrors($formErrors)
                ->withInput()
                ->with(AlertDataUtil::error('Error in registration process'));
        }

    }


    public function teacherRegister(Request $request){
        PermissionChecker::authorizeGate(AuthAbilities::TEACHER_REGISTER);
        return view ('auth.form-teacher-register');
    }


    public function postTeacherRegister(TeacherRegisterRequest $request){
        PermissionChecker::authorizeGate(AuthAbilities::TEACHER_REGISTER);

        try {

            $formErrors = optional(Session::get('errors'))->teacherReg;
            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation is failed');

            if($request->input('username') == null){
                $username = $this->authService->generateUsername($request);
                $request->merge(['username' => $username]);
            }

            // validate recaptcha
            $body = RecaptchaUtil::validate($request->input('g-recaptcha-response'));
            if(!$body->success)
                return back()->with(AlertDataUtil::error('Recaptcha validation failed'));

            // upload profile picture
            $file        = $request->input('profile_pic');
            $destination = isset($file) ? FileUploadUtil::upload($file,'users/teachers/') : null;

            $reqData = $request->all();
            $reqData['profile_pic'] = $destination;

            //register, activate and assign role for the account
            $user       = Sentinel::register($reqData);
            $activation = Activation::create($user);
            $role       = Sentinel::findRoleBySlug(RoleModel::TEACHER);
            $role->users()->attach($user);

            //send mail
            $email          = $user->email;
            $username       = $request->input('username');
            $activationLink = $this->authService->createActivationLink($user, $activation->code);
            Mail::to($email)->send(new TeacherRegMail($activationLink, $username));

            return view('form-submit-page')->with(
                AlertDataUtil::success('Successfully registered, check you emails to use account activation link',[
                    'title' => 'Teacher registration submit page'
                ])
            );

        }catch(CustomException $e){
            if(isset($destination) && ($destination != false))
                Storage::disk('public')->delete($destination);

            return redirect()->back()
                ->withErrors($formErrors)
                ->withInput()
                ->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Exception $e){
            if(isset($destination) && ($destination != false))
                Storage::disk('public')->delete($destination);

            //return redirect()->route('auth.register');
            return redirect()->back()
                ->withErrors($formErrors)
                ->withInput()
                ->with(AlertDataUtil::error('Error in registration process',[
                        //'message'   => $e->getMessage(),
                    ])
                );
        }


    }

}
