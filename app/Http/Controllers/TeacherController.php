<?php
namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Services\TeacherService;
use Sentinel;
use App\View\DataFormatters\TeacherDataFormatter;
//use Illuminate\Http\Request;


class TeacherController extends Controller
{

    private TeacherService $teacherService;

    function __construct(TeacherService $teacherService){
        $this->teacherService    = $teacherService;
    }

    public function viewAllTeachers(){
        $teachers       = $this->teacherService->loadAllAvailableTeachers();
        $teachersArr    = TeacherDataFormatter::prepareUserListData($teachers);
        return view('teacher-list')->with(['teachers' => $teachersArr]);
    }


    public function viewTeacher($username = null){
        if(!$username)
            throw new CustomException('Profile username not provided');

        $teacherData            = $this->teacherService->loadTeacherDataByUserName($username);
        $teacherCoursesData     = $this->teacherService->loadPublishedCoursesByTeacher($teacherData['dbRec']);

        $userarr     = TeacherDataFormatter::prepareUserData($teacherData);
        $coursesarr  = TeacherDataFormatter::prepareCourseData($teacherCoursesData);

        return view('view-teacher-profile')->with([
            'userData'          => $userarr,
            'teacher_courses'   => $coursesarr
        ]);
    }

}