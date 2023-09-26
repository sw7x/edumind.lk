<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Services\TeacherService;
//use Illuminate\Http\Request;
use Sentinel;
use App\View\DataTransformers\TeacherDataTransformer;




class TeacherController extends Controller
{

    private TeacherService $teacherService;
    
    function __construct(TeacherService $teacherService){
        $this->teacherService    = $teacherService;
    }



    public function viewAllTeachers()
    {
        try{

            $teachers       = $this->teacherService->loadAllAvailableTeachers();

            $teachersArr    = TeacherDataTransformer::prepareUserListData($teachers);
            return view('teacher-list')->with(['teachers' => $teachersArr]);
                       
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher-list'); 

        }catch(\Exception $e){
            session()->flash('message', $e->getMessage());
            //session()->flash('message', 'Unable to Load teachers');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher-list');  
        }
        
    }




    public function viewInstruction()
    {
        return view('teacher.teacher-instruction');
    }

    public function viewTeacherProfileHelp()
    {
        return view('teacher.teacher-profile-help');
    }

    public function viewTeacher($username = null){
        
        try{

            if(!$username)
                throw new CustomException('Profile username not provided');
            
            $teacherData            = $this->teacherService->loadTeacherDataByUserName($username);
            $teacherCoursesData     = $this->teacherService->loadPublishedCoursesByTeacher($teacherData['dbRec']);
            
            $userarr     = TeacherDataTransformer::prepareUserData($teacherData);
            $coursesarr  = TeacherDataTransformer::prepareCourseData($teacherCoursesData);
       
            return view('view-teacher-profile')->with([
                'userData'          => $userarr,
                'teacher_courses'   => $coursesarr
            ]);

        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('view-teacher-profile');

        }catch(\Exception $e){            
            session()->flash('message', $e->getMessage());
            //session()->flash('message', 'Failed to load teacher profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('view-teacher-profile');
        }

    }



    public function viewMyCourses()
    {
        try{
            $user = Sentinel::getUser();
            if(is_null($user))
                throw new CustomException('Access denied');
            
            $role = optional($user->roles()->first())->name;
            if($role != 'teacher')
                throw new CustomException('Wrong user type');

            $courses    = $this->teacherService->loadAllCoursesByTeacher($user);
            $coursesArr = TeacherDataTransformer::prepareCourseData($courses);

            return view('teacher.teacher-my-courses-full-width')->with([
            //return view('teacher-my-courses')->with([
                //'userData'          => $user,
                'teacher_courses'   => $coursesArr
            ]);

        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher.teacher-my-courses');

        }catch(\Exception $e){
            //dd($e->getMessage());            
            session()->flash('message', $e->getMessage());
             //session()->flash('message', 'Failed to load your courses');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher.teacher-my-courses');
        }        

    }


    public function profileEdit(){
        return view('teacher.teacher-profile-edit');
    }

    public function createCourse(){
        return view('teacher.teacher-profile-course-create');
    }

    public function courseAddContent(){
        return view('teacher.teacher-profile-course-add-content');
    }
    
    public function ViewEarnings(){
        return view('teacher.teacher-profile-earnings');
    }

    public function viewDashboard(){
        return view('teacher.teacher-profile-dashboard');
    }

    
}
