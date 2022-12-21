<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\User;
use App\Services\StudentService;
use App\Services\TeacherService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Sentinel;


class TeacherController extends Controller
{

    public function viewMyProfile()
    {
        //@if(!Sentinel::check())
        //Sentinel::getUser()->profile_pic
        //@if(Sentinel::getUser()->roles()->first()->slug == 'student')
        try{

            $user = Sentinel::getUser();

            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                if($role=='teacher'){
                    return view('teacher.teacher-my-profile-full-width')->with(['userData' => $user]);
                    //return view('teacher-my-profile')->with(['userData' => $user]);
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
            return view('teacher.teacher-my-profile');            

        }catch(\Exception $e){
            session()->flash('message', 'Failed to load your profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher.teacher-my-profile');
            
        }
    }

    public function viewAllTeachers()
    {
        $teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->where('status',1)->orderBy('id')->get();
        //$teachers->getCourseCount();
        //todo
        foreach($teachers as $teacher){
            //dump($teacher->getTeachingCourses);
        }
        //dd();
        //dd($teachers);
        return view('teacher-list')->with(['teachers' => $teachers]);
    }

    public function viewInstruction()
    {
        return view('teacher.teacher-instruction');
    }

    public function viewTeacherProfileHelp()
    {
        return view('teacher.teacher-profile-help');
    }

    public function viewTeacher($username = null)
    {
        //$username = 'lasantha50';
        //dd($username);
        try{
            if(!$username){
                throw new CustomException('Profile id not provided');
            }

            $user = User::where('username', $username)->first();

            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                if($role=='teacher'){

                    $teacherService     = new TeacherService();
                    $teacher_courses    = $teacherService->getPublishedCoursesByTeacher($user);

                    return view('view-teacher-profile')->with([
                        'userData'          => $user,
                        'teacher_courses'   => $teacher_courses
                    ]);

                }else{
                    throw new CustomException('Wrong user type');
                }

            }else{
                throw new CustomException('Teacher profile does not exists');
            }
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('view-teacher-profile');

        }catch(\Exception $e){
            session()->flash('message', 'Failed to load teacher profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('view-teacher-profile');

        }

    }



    public function viewMyCourses()
    {
        //todo
        try{

            $user = Sentinel::getUser();

            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                if($role=='teacher'){

                    $teacherService     = new TeacherService();
                    $teacher_courses    = $teacherService->getAllCoursesByTeacher($user);

                    return view('teacher.teacher-my-courses-full-width')->with([
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
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher.teacher-my-courses');

        }catch(\Exception $e){
            session()->flash('message', 'Failed to load your courses');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher.teacher-my-courses');

        }

    }


    public function profileEdit()
    {
        return view('teacher.teacher-profile-edit');
    }



    public function createCourse()
    {
        return view('teacher.teacher-profile-course-create');
    }

    public function courseAddContent()
    {
        return view('teacher.teacher-profile-course-add-content');
    }
    public function ViewEarnings()
    {
        return view('teacher.teacher-profile-earnings');
    }


    public function viewDashboard()
    {
        return view('teacher.teacher-profile-dashboard');
    }

    
}
