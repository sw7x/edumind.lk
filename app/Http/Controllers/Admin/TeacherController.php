<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Sentinel;
use App\Services\Admin\TeacherService as AdminTeacherService;
use App\Exceptions\CustomException;
use App\Models\Role as RoleModel;
use App\Common\SharedServices\UserSharedService;
use App\View\DataFormatters\Admin\TeacherDataFormatter as AdminTeacherDataFormatter;


class TeacherController extends Controller
{

    private AdminTeacherService $adminTeacherService;

    public function __construct(AdminTeacherService $adminTeacherService){
        $this->adminTeacherService = $adminTeacherService;
    }


    public function viewMyCourses(){       
        $user = Sentinel::getUser();
        if(is_null($user))
            throw new CustomException('Invalid page');

        if(!(new UserSharedService)->hasRole($user, RoleModel::TEACHER))
            throw new CustomException('Wrong user type');

        $teacherCourses    = $this->adminTeacherService->getAllCoursesByTeacher($user);
        $teacherCoursesArr = AdminTeacherDataFormatter::prepareMyCourseData($teacherCourses);

        return view('admin-panel.teacher.my-courses')->with(['teacher_courses' => $teacherCoursesArr]);
    }


    /*
    public function viewDashboard(){
    	return view('admin-panel.teacher.dashboard');
    }
    */

    // list-coupon-codes.blade
    // my-courses.blade
    // my-earnings.blade


    public function viewCourseEnrollmentList(){
        //need login, need valid role, role need to be teacher 

        if(!Sentinel::check())
            abort(403);
            
        $user = Sentinel::getUser();            
        
        if(!(new UserSharedService)->isHaveValidRole($user))
           abort(403);

        // redirect users that have TEACHER, STUDENT roles
        if(!(new UserSharedService)->hasRole($user, RoleModel::TEACHER))
           abort(403);
                    
        return view('admin-panel.teacher.course-enrollments');
    }


    public function viewCourseCompleteList(){
        //need login, need valid role, role need to be teacher 

        if(!Sentinel::check())
            abort(403);
            
        $user            = Sentinel::getUser();            
        $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
        $currentUserRole = optional($user->roles()->first())->name;        
        if(!in_array($currentUserRole, $allRoles))
            abort(403);
           
        // redirect users that have TEACHER, STUDENT roles
        $allowedRoles   =   [RoleModel::TEACHER];
        if(!in_array($currentUserRole, $allowedRoles))
            abort(404);
                    
        return view('admin-panel.teacher.course-completions');
    }

    
    public function viewMySalaries(){
        //need login, need valid role, role need to be teacher 
    
        if(!Sentinel::check())
            abort(403);
            
        $user            = Sentinel::getUser();            
        $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
        $currentUserRole = optional($user->roles()->first())->name;        
        if(!in_array($currentUserRole, $allRoles))
            abort(403);
           

        // redirect users that have TEACHER, STUDENT roles
        $allowedRoles   =   [RoleModel::TEACHER];
        if(!in_array($currentUserRole, $allowedRoles))
            abort(404);
                    
        return view('admin-panel.teacher.my-salary');
    }
    
}