<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Sentinel;
use App\Services\Admin\TeacherService as AdminTeacherService;
use App\Exceptions\CustomException;
use App\Models\Role as RoleModel;

use App\View\DataTransformers\Admin\TeacherDataTransformer as AdminTeacherDataTransformer;

class TeacherController extends Controller
{

    private AdminTeacherService $adminTeacherService;

    public function __construct(AdminTeacherService $adminTeacherService){
        $this->adminTeacherService = $adminTeacherService;
    }



    public function viewMyCourses(){
        //dd('hh');
    	try{
            $user = Sentinel::getUser();

            if(is_null($user))
                throw new CustomException('Invalid page');

            $role = is_null($user->roles()->first()) ? null : $user->roles()->first()->name;

            if($role != RoleModel::TEACHER)
                throw new CustomException('Wrong user type');

            $teacherCourses    = $this->adminTeacherService->getAllCoursesByTeacher($user);
            $teacherCoursesArr = AdminTeacherDataTransformer::prepareMyCourseData($teacherCourses);

        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($teacherCoursesArr);

        }catch(\Exception $e){
            //session()->flash('message','Failed to show your courses');
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($teacherCoursesArr);
        }

        return view('admin-panel.teacher.my-courses')->with([
            'teacher_courses'   => $teacherCoursesArr ?? null
        ]);
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
                    
        return view('admin-panel.teacher.course-enrollments');
    }


    public function viewCourseCompleteList(){
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


