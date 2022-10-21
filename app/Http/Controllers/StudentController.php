<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Sentinel;


class StudentController extends Controller
{

    public function viewMyCourses(Request $request)
    {

        try{

            $user = Sentinel::getUser();

            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                if($role=='student'){

                    $studentService     = new StudentService();
                    $student_courses    = $studentService->getCoursesByStudent($user);


                    //return view('student-my-courses')->with([
                    return view('student.student-my-courses-full-width')->with([
                        'userData'          => $user,
                        'student_courses'   => $student_courses
                        //'student_courses'   => null
                    ]);

                }else{
                    throw new CustomException('Wrong user type');
                }
            }else{
                throw new CustomException('Access denied');
            }
        }catch(CustomException $e){

            return view('student.student-my-courses-full-width')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
            //dd($e->getMessage());
            return view('student.student-my-courses-full-width')->with([
                //'message'     => 'Error!',
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }
    }



    public function viewMyProfile()
    {
        //@if(!Sentinel::check())
        //Sentinel::getUser()->profile_pic
        //@if(Sentinel::getUser()->roles()->first()->slug == 'student')
        try{

            $user = Sentinel::getUser();

            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                if($role=='student'){
                    return view('student.student-my-profile')->with(['userData' => $user]);
                    //return view('student-my-profile-full-width')->with(['userData' => $user]);
                }else{
                    throw new CustomException('Wrong user type');
                }
            }else{
                throw new CustomException('Access denied');
            }
        }catch(CustomException $e){

            return view('student.student-my-profile')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
            return view('student.student-my-profile')->with([
                'message'     => 'Student does not exist!',
                //'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }
    }

    public function loadDashboard()
    {
        return view('student.student-profile-dashboard');
    }

    public function viewStudent($username = null)
    {
        //$username = 'dasun50';
        try{

            if(!$username){
                throw new CustomException('Profile id not provided');
            }
            $user = User::where('username', $username)->first();

            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                if($role=='student'){
                    return view('view-student-profile')->with(['userData' => $user]);
                }else{
                    throw new CustomException('Wrong user type');
                }
            }else{
                throw new CustomException('Access denied');
            }
        }catch(CustomException $e){

            return view('view-student-profile')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
            return view('view-student-profile')->with([
                'message'     => 'Student does not exist!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }

    }




    public function profileEdit()
    {
        return view('student.student-profile-edit');
    }


    public function viewEnrolledCourses()
    {
        return view('student.student-my-courses');
    }


    public function viewDashboard()
    {
        return view('student.student-profile-dashboard');
    }



    public function viewHelp()
    {
        return view('student.student-profile-help');
    }


}
