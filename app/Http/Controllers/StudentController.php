<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Sentinel;
use App\Models\Course;
use App\Models\CourseSelection;

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
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-courses-full-width');

        }catch(\Exception $e){

            //dd($e->getMessage());
            session()->flash('message', 'Failed to load your courses');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-courses-full-width');

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
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-profile');

        }catch(\Exception $e){
            session()->flash('message', 'Failed to load your profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-profile');
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
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('view-student-profile');

        }catch(\Exception $e){
            session()->flash('message', 'Failed to load student profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('view-student-profile');
            //Student does not exist!
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

    public function viewCart()
    {
        return view('student.cart');
        

        /*
        $user = Sentinel::getUser();

        $addedCourses =  Course::join('course_selections', function($join) use ($user){
                        $join->on('courses.id','=','course_selections.course_id')
                            ->where('course_selections.is_checkout', '=', 0)
                            ->where('course_selections.student_id', '=', $user->id)
                            ->where('courses.status', '=', "published");
                    })
                    
                    ->get([
                        'course_selections.is_checkout',
                        //'enrollments.is_complete',
                        'courses.*'
                    ]);

        $totPrice = 0;
        foreach ($addedCourses as $key => $course) {
             $totPrice +=  $course->price;
        }        



        //dd($addedCourses);            
        return view('student.cart')->with([
            'addedCourses'  => $addedCourses,
            'totalPrice'    => $totPrice
        ]);
        */
    }

    
}
