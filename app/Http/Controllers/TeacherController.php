<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Services\TeacherService;
use Sentinel;
use App\View\DataTransformers\TeacherDataTransformer;

//use App\Models\Role as RoleModel;
//use Illuminate\Http\Request;

class TeacherController extends Controller
{

    private TeacherService $teacherService;

    function __construct(TeacherService $teacherService){
        $this->teacherService    = $teacherService;
    }

    public function viewAllTeachers(){
        $teachers       = $this->teacherService->loadAllAvailableTeachers();

        $teachersArr    = TeacherDataTransformer::prepareUserListData($teachers);
        return view('teacher-list')->with(['teachers' => $teachersArr]);
    }


    public function viewTeacher($username = null){
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
    }


    /*
    //use later if need
    public function viewMyCourses(){
        
        $user = Sentinel::getUser();
        if(is_null($user))
            abort(401, 'Authentication is required To access this page');

        $role = optional($user->roles()->first())->name;
        if($role != RoleModel::TEACHER)
            abort(403, 'Wrong user type');

        $courses    = $this->teacherService->loadAllCoursesByTeacher($user);
        $coursesArr = TeacherDataTransformer::prepareCourseData($courses);

        //return view('teacher.my-courses-full-width')->with([
        return view('teacher.my-courses')->with([
            //'userData'          => $user,
            'teacher_courses'   => $coursesArr
        ]);       

    }
    */

}