<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use App\Services\TeacherService;


class TeacherController extends Controller
{


public function viewMyCourses(){

	try{

            $user = Sentinel::getUser();

            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                if($role=='teacher'){

                    $teacherService     = new TeacherService();
                    $teacher_courses    = $teacherService->getAllCoursesByTeacher($user);

                    return view('admin-panel.teacher.my-courses')->with([
                    //return view('teacher-my-courses')->with([
                        'userData'          => $user,
                        'teacher_courses'   => $teacher_courses
                    ]);

                }else{
                    throw new CustomException('Wrong user type');
                }
            }else{
                throw new CustomException('Access denied');
            }
        }catch(CustomException $e){
            return view('admin-panel.teacher.my-courses')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }catch(\Exception $e){
            //dd($e->getMessage());
            return view('admin-panel.teacher.my-courses')->with([
                //'message'     => 'Error!',
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }





	//return view('admin-panel.teacher.my-courses');

}
        
public function ViewEarnings(){
	return view('admin-panel.teacher.my-earnings');

}

public function viewDashboard(){
	return view('admin-panel.teacher.dashboard');

}

public function profileEdit(){
	return view('admin-panel.teacher.edit-profile');

}        


// list-cupon-codes.blade
// my-courses.blade
// my-earnings.blade









}
