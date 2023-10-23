<?php
namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Services\StudentService;
use Illuminate\Http\Request;
use App\View\DataFormatters\StudentDataFormatter;
use Sentinel;
use App\Models\Role as RoleModel;
use App\Common\SharedServices\UserSharedService;


class StudentController extends Controller
{

    private StudentService $studentService;
    private UserSharedService $userSharedService;

    function __construct(StudentService $studentService, UserSharedService $userSharedService){
        $this->studentService    = $studentService;
        $this->userSharedService = $userSharedService;
    }


    public function enrolledCourses(Request $request){
        $user            = Sentinel::getUser();
        $enrolledCourses = $this->studentService->getStudentEnrolledCourses($user);
        $coursesArr      = StudentDataFormatter::prepareEnrolledCourseData($enrolledCourses);

        return view('student.my-courses')->with(['student_courses'   => $coursesArr]);
        //return view('student.my-courses-full-width')->with(['student_courses'   => $coursesArr]);
    }



    public function loadDashboard(){
        return view('student.dashboard');
    }


    public function viewStudent(?string $username = null){
        if(!$username)
            throw new CustomException('Profile username does not provided');

        $studentData = $this->studentService->loadStudentDataByUserName($username);
        $userarr     = StudentDataFormatter::prepareUserData($studentData);

        return view('view-student-profile')->with(['userData' =>  $userarr]);
    }


    public function studentEnrolledCourses(?string $username = null){
        if(!$username)
            throw new CustomException('Profile username does not provided');

        $enrolledCourses = $this->studentService->loadStudentEnrolledCoursesByUsername($username);
        $coursesArr      = StudentDataFormatter::prepareEnrolledCourseData($enrolledCourses);

        return view('student.student-enrolled-courses')->with(['student_courses'   => $coursesArr]);
    }

}