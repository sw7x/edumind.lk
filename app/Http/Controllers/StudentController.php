<?php
namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Exceptions\InvalidUserTypeException;
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


    public function viewEnrolledCoursesPage(Request $request){
        
        $user = Sentinel::getUser();
        if(is_null($user))
            abort(401, 'Authentication is required To access this page');
        
        $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
        $currentUserRole = optional($user->roles()->first())->name;        
        if(!in_array($currentUserRole, $allRoles))
            throw new InvalidUserTypeException('Your user role is not valid for access this page.');

        
        // prevent access users that have ADMIN, EDITOR, MARKETER, TEACHER roles
        $allowedRoles = [RoleModel::STUDENT];
        if(!in_array($currentUserRole, $allowedRoles))
            throw new CustomException('Invalid page');
            
        $enrolledCourses = $this->studentService->getStudentEnrolledCourses($user);
        $coursesArr      = StudentDataTransformer::prepareEnrolledCourseData($enrolledCourses);

        return view('student.my-courses')->with(['student_courses'   => $coursesArr]);
        //return view('student.my-courses-full-width')->with(['student_courses'   => $coursesArr]);        
    }



    public function loadDashboard(){
        return view('student.dashboard');
    }


    public function viewStudent(?string $username = null){
        if(!$username)
            throw new CustomException('Profile username not provided');

        $studentData = $this->studentService->loadStudentDataByUserName($username);
        $userarr     = StudentDataTransformer::prepareUserData($studentData);
        
        return view('view-student-profile')->with(['userData' =>  $userarr]);       
    }


    public function viewStudentEnrolledCourses(?string $username = null){

        if(!$username)
            throw new CustomException('Profile username not provided');

        $user = Sentinel::getUser();
        if(is_null($user))
            abort(403, "As a guest you dont have permission to access this page");
        
        $currentUserRole = optional($user->roles()->first())->name;
            
        // prevent access users that have ADMIN, EDITOR, TEACHER roles
        $allowedRoles = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER,];
        if(!in_array($currentUserRole, $allowedRoles))
            abort(403, "You dont have permission to access this page");

        
        $enrolledCourses = $this->studentService->loadStudentEnrolledCoursesByUsername($username);
        $coursesArr      = StudentDataTransformer::prepareEnrolledCourseData($enrolledCourses);

        return view('student.student-enrolled-courses')->with(['student_courses'   => $coursesArr]);
    }

}
