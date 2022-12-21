<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use App\Services\TeacherService;
use App\Exceptions\CustomException;

class TeacherController extends Controller
{


    public function viewMyCourses(){
        //dd('hh');
    	try{
            $user = Sentinel::getUser();

            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                if($role=='teacher'){

                    $teacherService     = new TeacherService();
                    $teacher_courses    = $teacherService->getAllCoursesByTeacher($user);                        

                }else{
                    throw new CustomException('Wrong user type');
                }
            }else{
                throw new CustomException('Access denied');
            }

        }catch(CustomException $e){                
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($teacher_courses);

        }catch(\Exception $e){                
            session()->flash('message','Failed to show your courses');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($teacher_courses);
        }

        return view('admin-panel.teacher.my-courses')->with([            
            'teacher_courses'   => $teacher_courses??null
        ]);
    }
            
    public function ViewEarnings(){
    	return view('admin-panel.teacher.my-earnings');

    }

    /*public function viewDashboard(){
    	return view('admin-panel.teacher.dashboard');
    }*/

    public function profileEdit(){
    	return view('admin-panel.teacher.edit-profile');

    }        


    // list-cupon-codes.blade
    // my-courses.blade
    // my-earnings.blade

    public function viewCourseEnrollmentList(){
        return view('admin-panel.teacher.course-enrollments');
    }   


    public function viewCourseCompleteList(){
        return view('admin-panel.teacher.course-completions');
    } 

    public function viewMySalary(){
        return view('admin-panel.teacher.my-salary');
    }



}
