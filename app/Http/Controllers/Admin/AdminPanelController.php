<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Sentinel;
use App\Models\Role as RoleModel;
use App\Exceptions\CustomException;
use App\Builders\UserBuilder;
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
            $adminPanelAllowedRoles = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER];
            if(!in_array($currentUserRole, $adminPanelAllowedRoles))
                return redirect()->route('profile', []);
                

            // load page with data for ADMIN / EDITOR / MARKETER user roles
            //$userData   =   $this->adminUserService->findDbRec($user->id);
            $userData   =   $this->adminUserService->loadLoggedInUserData();
            $userArr    =   AdminProfileDataTransformer::prepareUserData($userData);
            return view('admin-panel.profile')->with(['userData' => $userArr]);         
    
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher.teacher-my-profile'); 

        }catch(\Exception $e){
            session()->flash('message', $e->getMessage());
            //session()->flash('message', 'Failed to load your profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher.teacher-my-profile');  
        }
    }






	public function viewDashboard(){
    	//dd(auth()->user());
		if(sentinel::check()){
            $userRole = Sentinel::getUser()->roles()->first()->slug;

            if($userRole == RoleModel::STUDENT){

                /*return redirect(route('no-permission'))->with([
                    'message'     => 'You dont have permission to access this page',
                    'cls'         => "flash-warning",
                    'msgTitle'    => 'Warning !',
                ]);*/
                abort(403);

            }else if($userRole == RoleModel::ADMIN){
               return view('admin-panel.admin.dashboard');
            }else if($userRole == RoleModel::EDITOR){
				return view('admin-panel.editor.dashboard');
            }else if($userRole == RoleModel::MARKETER){
            	return view('admin-panel.marketer.dashboard');
            }else if($userRole == RoleModel::TEACHER){
            	return view('admin-panel.teacher.dashboard');
            }else{
            	abort(403);
            }

        }else{

        	return redirect(route('auth.login'))->with([
                'message'     => 'You dont have permission to access this page',
                'cls'         => "flash-warning",
                'msgTitle'    => 'Warning !',
            ]);
        }

    }



}
