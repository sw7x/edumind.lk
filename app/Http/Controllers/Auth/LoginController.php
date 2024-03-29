<?php
namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use Cartalyst\Sentinel\checkpoints\ThrottlingException;
use Cartalyst\Sentinel\checkpoints\NotActivatedException;
use App\Exceptions\WrongUserTypeException;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Validator;
use App\Models\Role as RoleModel;
use App\Common\Utils\AlertDataUtil;
use App\Common\SharedServices\UserSharedService;

use App\Permissions\Abilities\AuthAbilities;
use App\Permissions\Traits\GateCheck;


class LoginController extends Controller
{
    use GateCheck;

    public function __construct(){
        
    }


    public function login(){
        $this->hasGateAllowed(AuthAbilities::LOGIN);
        return view ('auth.form-login');
    }

    
    public function loginSubmit(Request $request){
        $this->hasGateAllowed(AuthAbilities::LOGIN);

        try{

            $validator = Validator::make($request->all(), [
                'email'     =>'required',
                'password'  =>'required|min:6|max:12',
            ],[
                'email.required'    => 'Username or Email is required.',
                'password.required' => 'password field is required.',
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator,'loginForm')->withInput();

            $remember_me = isset($request->remeber_me) ? true : false;
            $credentials = ['login' => $request->email];
            $user        = Sentinel::findByCredentials($credentials);

            if(is_null($user))
                throw new CustomException('Invalid user or account diabled');

            
            $arr = ['login' => $request->email, 'password' => $request->password];
            if(Sentinel::authenticate($arr, $remember_me)){
                $userSharedSvc  = new UserSharedService();
                $currentUser    = Sentinel::getUser();

                if($userSharedSvc->hasRole($currentUser, RoleModel::TEACHER)){
                    return redirect()->route('admin.profile', []);

                }else if($userSharedSvc->hasRole($currentUser, RoleModel::STUDENT)){
                    return redirect()->route('dashboard', []);

                }else{
                    //throw new WrongUserTypeException('You dont have permission to login here');
                    return redirect()->route('admin.dashboard');
                }

            }else{
                $pwResetTxt = "if you dont remember your password then you can reset it in here <a class='text-blue-600' href='".route("auth.reset-password-req-page")."'>Reset</a>";
                return redirect()->back()
                    ->with(AlertDataUtil::error('Wrong credentials',['message2' => $pwResetTxt]));
            }

        }
        catch(ThrottlingException $e){
            $delay = $e->getDelay();
            return redirect()->back()->with(
                AlertDataUtil::error("You are banned for {$delay} seconds",[
                    //'title'   => 'Student Registration submit page'
                ])
            );

        }catch(NotActivatedException $e){
            return redirect()->back()->with(
                AlertDataUtil::warning('You account is not activated',[
                    //'title'   => 'Student Registration submit page'
                ])
            );

        }
        catch(WrongUserTypeException $e){
            return redirect()->back()->with(
                AlertDataUtil::error($e->getMessage(),[
                    //'title'   => 'Student Registration submit page',
                ])
            );

        }
        catch(CustomException $e){
            return redirect()->back()->with(
                AlertDataUtil::error($e->getMessage(),[
                    //'message' => $e->getMessage(),
                    //'title'   => 'Student Registration submit page'
                ])
            );

        }
        catch(\Exception $e){
            return redirect()->back()->with(
                AlertDataUtil::error('Something is wrong in login',[
                    'message' => $e->getMessage(),
                    //'title'   => 'Student Registration submit page'
                ])
            );

        }

    }


    //todo
    public function logout(Request $request){
        $this->hasGateAllowed(AuthAbilities::LOGOUT);

        if(sentinel::check()){
            Sentinel::logout();
        }else{
            //return redirect()->route('auth.login');
        }

        return redirect()->route('auth.login');

    }

}
