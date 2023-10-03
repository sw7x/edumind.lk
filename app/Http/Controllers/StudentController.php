<?php
namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Services\StudentService;
use Illuminate\Http\Request;
use App\View\DataTransformers\StudentDataTransformer;
use Sentinel;
use App\Models\Role as RoleModel;


class StudentController extends Controller
{

    private StudentService $studentService;


    function __construct(StudentService $studentService){
        $this->studentService    = $studentService;
    }

    //public function viewMyCourses(Request $request)
    public function viewEnrolledCoursesPage(Request $request)
    {
        try{

            $user = Sentinel::getUser();
            if(is_null($user))
                throw new CustomException('Invalid page');
            
            $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
            $currentUserRole = optional($user->roles()->first())->name;        
            if(!in_array($currentUserRole, $allRoles))
                throw new CustomException('Invalid user type');

            
            // redirect users that have ADMIN, EDITOR, MARKETER, TEACHER roles
            $allowedRoles = [RoleModel::STUDENT];
            if(!in_array($currentUserRole, $allowedRoles))
                throw new CustomException('Invalid page');

            $enrolledCourses = $this->studentService->getLoggedInUserEnrolledCourses();
            $coursesArr      = StudentDataTransformer::prepareEnrolledCourseData($enrolledCourses);

            return view('student.student-my-courses')->with([
            //return view('student.student-my-courses-full-width')->with([
                //'userData'          => $user,
                'student_courses'   => $coursesArr
            ]);

        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-courses-full-width');

        }catch(\Exception $e){
            //dd($e->getMessage());
            //session()->flash('message', $e->getMessage());
            session()->flash('message', 'Failed to load your courses');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-courses-full-width');

        }
    }



    public function loadDashboard(){
        return view('student.student-profile-dashboard');
    }

    public function viewStudent($username = null){
        try{

            if(!$username)
                throw new CustomException('Profile username not provided');

            $studentData = $this->studentService->loadStudentDataByUserName($username);
            $userarr     = StudentDataTransformer::prepareUserData($studentData);

            return view('student.student-my-profile')->with(['userData' =>  $userarr]);

        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('view-student-profile');

        }catch(\Exception $e){
            //session()->flash('message', $e->getMessage());
            session()->flash('message', 'Failed to load student profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('view-student-profile');
            //Student does not exist!
        }

    }





    


    public function viewEnrolledCourses(){
        return view('student.student-my-courses');
    }






    




}
