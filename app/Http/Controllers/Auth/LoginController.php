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
use Illuminate\Support\Facades\Auth;
use App\Models\Role as RoleModel;

class LoginController extends Controller
{
    public function __construct()
    {   $this->middleware('checkGuest',
            ['only' => ['login']]
        );
    }


    public function login(){
        return view ('auth.form-login');
    }

    //todo
    public function loginSubmit(Request $request){

        
        $validator = Validator::make($request->all(), [
            'email'     =>'required',
            'password'  =>'required|min:6|max:12',
        ],[
            'email.required'                => 'Username or Email is required.',
            'password.required'             => 'password field is required.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            if(isset($request->remeber_me)){
                $remember_me = true;
            }else{
                $remember_me = false;
            }
            //dd($remember_me);
            try{

                $credentials = ['login'    => $request->email];
                $user = Sentinel::findByCredentials($credentials);


                /*dd($user);

                if($user->status == 0){
                    throw new CustomException('Account is disable by admin');
                }*/

                if($user == null){
                    throw new CustomException('Invalid user or account diabled');
                }else{                  

                    $role = $user->roles()->first()->slug;
                    if($role != RoleModel::TEACHER && $role != RoleModel::STUDENT){
                        //throw new WrongUserTypeException('You dont have permission to login here');
                    }
                }


                if(Sentinel::authenticate([
                    'login' => $request->email,
                    'password' => $request->password],$remember_me)){

                    $role = Sentinel::getUser()->roles()->first()->slug;
                    
                    if($role == RoleModel::TEACHER){
                        return redirect()->route('teacher.my-profile', []);
                    }else if($role == RoleModel::STUDENT){
                        return redirect()->route('dashboard', []);
                    }else{
                        //throw new WrongUserTypeException('You dont have permission to login here');
                        //return redirect('/student-profile-dashboard');
                        return redirect()->route('admin.dashboard');
                    }




                }else{
                    $pwResetTxt = "if you dont remember your password then you can reset it in here <a class='text-blue-600' href='".route("auth.reset-password")."'>Reset</a>";
                    return redirect()->back()->with([
                        'message'  => 'Wrong credentials',
                        //'message2' => $pwResetTxt,
                        //'title'   => 'Student Registration submit page',
                        'cls'     => 'flash-danger',
                        'msgTitle'=> 'Error!',
                    ]);
                }
            }
            catch(ThrottlingException $e){
                $delay = $e->getDelay();

                return redirect()->back()->with([
                    'message' => "You are banned for {$delay} seconds",
                    //'title'   => 'Student Registration submit page',
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ]);
            }catch(NotActivatedException $e){

                return redirect()->back()->with([
                    'message' => "You account is not activated",
                    //'title'   => 'Student Registration submit page',
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }
            catch(WrongUserTypeException $e){
                return redirect()->back()->with([
                    'message' => $e->getMessage(),
                    //'title'   => 'Student Registration submit page',
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ]);
            }
            catch(CustomException $e){
                return redirect()->back()->with([
                    'message' => $e->getMessage(),
                    //'title'   => 'Student Registration submit page',
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ]);
            }
            catch(\Exception $e){
                return redirect()->back()->with([
                    //'message' => 'Something is wrong in login',
                    'message' => $e->getMessage(),
                    //'title'   => 'Student Registration submit page',
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ]);
            }
        }

    }

    //todo
    public function logout(Request $request){


        if(sentinel::check()){
            //$role = Sentinel::getUser()->roles()->first()->slug;
            Sentinel::logout();
            /*
            //if($role == 'admin' || $role == 'editor' || $role == RoleModel::MARKETER){
            if($role == RoleModel::ADMIN || $role == RoleModel::EDITOR || $role == RoleModel::MARKETER){
                return redirect()->route('admin.login');
            }else{
                return redirect()->route('home');
            }
            */
        }else{
            //return redirect()->route('auth.login');
        }

        return redirect()->route('auth.login');




    }







}
