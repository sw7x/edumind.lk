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


    public function viewMyCourses(){
        //dd('hh');
    	try{
            $user = Sentinel::getUser();

            if(is_null($user))
                throw new CustomException('Access denied');

            $role = is_null($user->roles()->first()) ? null : $user->roles()->first()->name;

            if($role != RoleModel::TEACHER)
                throw new CustomException('Wrong user type');

            $teacherCourses    = (new AdminTeacherService())->getAllCoursesByTeacher($user);
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


    public function ViewEarnings(){
    	return view('admin-panel.teacher.my-earnings');

    }

    /*public function viewDashboard(){
    	return view('admin-panel.teacher.dashboard');
    }*/

    public function myProfileEdit(){
    	return view('admin-panel.teacher.edit-profile');

    }


    // list-coupon-codes.blade
    // my-courses.blade
    // my-earnings.blade

    public function viewCourseEnrollmentList(){
        return view('admin-panel.teacher.course-enrollments');
    }


    public function viewCourseCompleteList(){
        return view('admin-panel.teacher.course-completions');
    }

    public function viewMySalaries(){
        return view('admin-panel.teacher.my-salary');
    }



}


