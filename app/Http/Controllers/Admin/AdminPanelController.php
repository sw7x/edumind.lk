<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Sentinel;
use App\Models\Role as RoleModel;
use App\Exceptions\CustomException;
use App\Exceptions\InvalidUserTypeException;
//use Illuminate\Http\Request;
use App\Services\Admin\UserService as AdminUserService;
use App\View\DataFormatters\Admin\ProfileDataFormatter as AdminProfileDataFormatter;
use App\Common\SharedServices\UserSharedService;

class AdminPanelController extends Controller
{

    private AdminUserService $adminUserService;

    function __construct(AdminUserService $adminUserService){
        $this->adminUserService  = $adminUserService;
    }


    public function viewProfile(){
        $user = Sentinel::getUser();
        if(is_null($user))
            abort(401, 'You need to login before access this page');
                
        if(!(new UserSharedService)->isHaveValidRole($user))        
            throw new InvalidUserTypeException('Invalid user type');

        // redirect users that have TEACHER, STUDENT roles
        $adminPanelAllowedRoles = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER];
        if(!(new UserSharedService)->hasAnyRole($user, $adminPanelAllowedRoles))        
            return redirect()->route('profile', []);
    
        // load page with data for ADMIN / EDITOR / MARKETER user roles
        $userData   =   $this->adminUserService->loadLoggedInUserData();
        $userArr    =   AdminProfileDataFormatter::prepareUserData($userData);
        return view('admin-panel.profile')->with(['userData' => $userArr]);
    }


    public function viewProfileEdit(){
        $user = Sentinel::getUser();
        if(is_null($user))
            return redirect()->route('profile-edit', []);

        if(!(new UserSharedService)->isHaveValidRole($user))        
            throw new InvalidUserTypeException('Invalid user type');

        if((new UserSharedService)->hasRole($user, RoleModel::STUDENT)){
            return redirect()->route('profile-edit', []);

        }else if((new UserSharedService)->hasRole($user, RoleModel::TEACHER)){
            return view('admin-panel.teacher.edit-profile');

        }else{
            abort(404, 'This page has nothing to do with your user role.');

        }

        // load page with data for ADMIN / EDITOR / MARKETER user roles
        $userData   =   $this->adminUserService->loadLoggedInUserData();
        $userArr    =   AdminProfileDataFormatter::prepareUserData($userData);
        return view('admin-panel.profile')->with(['userData' => $userArr]);
    }


	public function viewDashboard(){
        try{

            $user = Sentinel::getUser();
            if(is_null($user))
                abort(401, 'You need to login before access this page');

            if(!(new UserSharedService)->isHaveValidRole($user))        
                throw new InvalidUserTypeException('Invalid user type');
            

            // redirect users that have TEACHER, STUDENT roles
            $adminPanelAllowedRoles = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER];
            if(!(new UserSharedService)->hasAnyRole($user, $adminPanelAllowedRoles))        
                return redirect()->route('profile', []);
            
            
            if((new UserSharedService)->hasRole($user, RoleModel::ADMIN)){
                $view    =   'admin-panel.admin.dashboard';

            }elseif ((new UserSharedService)->hasRole($user, RoleModel::EDITOR)){
                $view    =   'admin-panel.editor.dashboard';

            }elseif ((new UserSharedService)->hasRole($user, RoleModel::MARKETER)){
                $view    =   'admin-panel.marketer.dashboard';

            }else{
                //$currentUserRole == RoleModel::TEACHER
                $view    =   'admin-panel.teacher.dashboard';
            }

            return view($view);

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Failed to load your dashboard';
            session()->now('message', $msg);
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.profile');
        }
    }


    public function ViewMyEarnings(){
        if(!Sentinel::check())
            abort(401, 'You need to login before access this page');

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))        
            throw new InvalidUserTypeException('Invalid user type');

        // redirect users that have TEACHER, STUDENT roles
        $adminPanelAllowedRoles = [RoleModel::MARKETER, RoleModel::TEACHER];
        if(!(new UserSharedService)->hasAnyRole($user, $adminPanelAllowedRoles))        
            abort(404);    

        $view   =   ($currentUserRole == RoleModel::TEACHER) ?
                        'admin-panel.teacher.my-earnings' : // TEACHER
                        'admin-panel.marketer.my-earnings'; // MARKETER

        // load page with data for EDITOR / MARKETER user roles
        return view($view);
    }

}
