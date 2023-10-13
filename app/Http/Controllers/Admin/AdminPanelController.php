<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Sentinel;
use App\Models\Role as RoleModel;
use App\Exceptions\CustomException;
//use App\Builders\UserBuilder;
//use Illuminate\Support\Facades\Auth;
//use App\Mappers\UserMapper;
//use App\Mappers\RoleMapper;
//use App\Domain\Factories\UserFactory;
//use App\Domain\Factories\RoleFactory;
//use Illuminate\Http\Request;
use App\Services\Admin\UserService as AdminUserService;
use App\View\DataTransformers\Admin\ProfileDataTransformer as AdminProfileDataTransformer;

class AdminPanelController extends Controller
{

    private AdminUserService $adminUserService;

    function __construct(AdminUserService $adminUserService){
        $this->adminUserService  = $adminUserService;
    }



    public function viewProfile(){
        try{

            $user = Sentinel::getUser();
            if(is_null($user))
                throw new CustomException('Access denied');

            $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
            $currentUserRole = optional($user->roles()->first())->name;
            if(!in_array($currentUserRole, $allRoles))
                throw new CustomException('Invalid user type');

            // redirect users that have TEACHER, STUDENT roles
            $adminPanelAllowedRoles = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER];
            if(!in_array($currentUserRole, $adminPanelAllowedRoles))
                return redirect()->route('profile', []);


            // load page with data for ADMIN / EDITOR / MARKETER user roles
            //$userData   =   $this->adminUserService->findDbRec($user->id);
            $userData   =   $this->adminUserService->loadLoggedInUserData();
            $userArr    =   AdminProfileDataTransformer::prepareUserData($userData);
            return view('admin-panel.profile')->with(['userData' => $userArr]);


        }catch(CustomException $e){
            session()->now('message', $e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.profile');

        }catch(\Exception $e){
            session()->now('message', $e->getMessage());
            //session()->now('message', 'Failed to load your profile');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.profile');
        }
    }

    public function viewProfileEditPage(){
        try{

            $user = Sentinel::getUser();
            if(is_null($user))
                return redirect()->route('profile-edit', []);


            $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
            $currentUserRole = optional($user->roles()->first())->name;
            if(!in_array($currentUserRole, $allRoles))
                throw new CustomException('Invalid user type');

            if($currentUserRole == RoleModel::STUDENT){
                return redirect()->route('profile-edit', []);

            }else if($currentUserRole == RoleModel::TEACHER){
                return view('admin-panel.teacher.edit-profile');
            }else{
                throw new CustomException('Invalid user type');
                //404
            }




            // load page with data for ADMIN / EDITOR / MARKETER user roles
            //$userData   =   $this->adminUserService->findDbRec($user->id);
            $userData   =   $this->adminUserService->loadLoggedInUserData();
            $userArr    =   AdminProfileDataTransformer::prepareUserData($userData);
            return view('admin-panel.profile')->with(['userData' => $userArr]);


        }catch(CustomException $e){
            session()->now('message', $e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            //return view('admin-panel.dashboard');
            abort(404,'hhh');

        }catch(\Exception $e){
            session()->now('message', $e->getMessage());
            //session()->now('message', 'Failed to load your profile');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.profile');
        }
    }








	public function viewDashboard(){

        try{

            $user = Sentinel::getUser();
            if(is_null($user))
                throw new CustomException('Access denied');

            $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
            $currentUserRole = optional($user->roles()->first())->name;
            if(!in_array($currentUserRole, $allRoles))
                throw new CustomException('Invalid user type');

            // redirect users that have TEACHER, STUDENT roles
            $adminPanelAllowedRoles = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER];
            if(!in_array($currentUserRole, $adminPanelAllowedRoles))
                return redirect()->route('dashboard', []);


            if($currentUserRole == RoleModel::ADMIN){
                $view    =   'admin-panel.admin.dashboard';
            }else if($currentUserRole == RoleModel::EDITOR){
                $view    =   'admin-panel.editor.dashboard';
            }else if($currentUserRole == RoleModel::MARKETER){
                $view    =   'admin-panel.marketer.dashboard';
            }else{
                //$currentUserRole == RoleModel::TEACHER
                $view    =   'admin-panel.teacher.dashboard';
            }

            // load page with data for ADMIN / EDITOR / MARKETER user roles
            //$userData   =   $this->adminUserService->findDbRec($user->id);
            //$userData   =   $this->adminUserService->loadLoggedInUserData();
            //$userArr    =   AdminProfileDataTransformer::prepareUserData($userData);
            //return view('admin-panel.profile')->with(['userData' => $userArr]);
            return view($view);

        }catch(CustomException $e){
            session()->now('message', $e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.profile');

        }catch(\Exception $e){
            session()->now('message', $e->getMessage());
            //session()->now('message', 'Failed to load your profile');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.profile');
        }
    }



    /*
    public function ViewMyEarnings(){
        //try{

            if(!Sentinel::check())
                abort(403);
                // return redirect()->route('home',[])->with([
                //     'message'     => 'Access denied',
                //     'cls'         => 'flash-danger',
                //     'msgTitle'    => 'Error !',
                // ]);

            $user            = Sentinel::getUser();
            $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
            $currentUserRole = optional($user->roles()->first())->name;
            if(!in_array($currentUserRole, $allRoles))
                abort(403);
                // return redirect()->route('home',[])->with([
                //     'message'     => 'Access denied',
                //     'cls'         => 'flash-danger',
                //     'msgTitle'    => 'Error !',
                // ]);



            // redirect users that have TEACHER, STUDENT roles
            $adminPanelAllowedRoles = [RoleModel::MARKETER, RoleModel::TEACHER];
            if(!in_array($currentUserRole, $adminPanelAllowedRoles)){
                abort(404);
                //return redirect()->route('dashboard', []);

                //throw new CustomException('Invalid user type');


                if($currentUserRole == RoleModel::STUDENT)
                    //abort(404);
                    // return redirect()->route('dashboard',[])->with([
                    //     'message'     => 'Invalid page',
                    //     'cls'         => 'flash-danger',
                    //     'msgTitle'    => 'Error !',
                    // ]);
                else
                    //abort(404);
            }


            if($currentUserRole == RoleModel::TEACHER){
                $view    =   'admin-panel.teacher.my-earnings';
            }else if($currentUserRole == RoleModel::MARKETER){
                $view    =   'admin-panel.marketer.my-earnings';
            }

            // load page with data for EDITOR / MARKETER user roles
            return view($view);

        // }catch(CustomException $e){
        //     //return
        //     session()->now('message', $e->getMessage());
        //     session()->now('cls','flash-danger');
        //     session()->now('msgTitle','Error!');
        //     return view('admin-panel.profile');

        // }catch(\Exception $e){
        //     session()->now('message', $e->getMessage());
        //     //session()->now('message', 'Failed to load your profile');
        //     session()->now('cls','flash-danger');
        //     session()->now('msgTitle','Error!');
        //     return view('admin-panel.profile');
        // }

    }*/


    public function ViewMyEarnings(){

        if(!Sentinel::check())
            abort(403);

        $user            = Sentinel::getUser();
        $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
        $currentUserRole = optional($user->roles()->first())->name;
        if(!in_array($currentUserRole, $allRoles))
            abort(403);


        // redirect users that have TEACHER, STUDENT roles
        $adminPanelAllowedRoles = [RoleModel::MARKETER, RoleModel::TEACHER];
        if(!in_array($currentUserRole, $adminPanelAllowedRoles))
            abort(404);


        $view   =   ($currentUserRole == RoleModel::TEACHER) ?
                        'admin-panel.teacher.my-earnings' : // TEACHER
                        'admin-panel.marketer.my-earnings'; // MARKETER

        // load page with data for EDITOR / MARKETER user roles
        return view($view);
    }






}
