<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use App\Services\TeacherService;
use App\View\DataTransformers\HomePageDataTransformer;
use Sentinel;
/*
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use App\Exceptions\CustomException;
use App\Models\Course as CourseModel;
use App\Models\CourseSelection as CourseSelectionModel;
*/

class HomeController extends Controller
{

    private CourseService $courseService;
    private TeacherService $teacherService;

    function __construct(CourseService $courseService, TeacherService $teacherService){
        $this->courseService    = $courseService;
        $this->teacherService   = $teacherService;

        /*
            $this->middleware('auth');

            $this->middleare(function($request,$next){
                $this->user=Auth::user(); // here the user should exist from the session
                return $next($request);
            });
        */
    }


    public function index(){
        $teachers          = $this->teacherService->loadPopularTeachers();
        $newCourses        = $this->courseService->loadNewCourses();
        $popularCourses    = $this->courseService->loadPopularCourses();

        $newCoursesArr     = HomePageDataTransformer::prepareCourseDataList($newCourses);
        $popularCoursesArr = HomePageDataTransformer::prepareCourseDataList($popularCourses);
        $teachersArr       = HomePageDataTransformer::prepareTeacherDataList($teachers);

        return view('home')->with([
            'teachers'          => $teachersArr,
            'new_courses'       => $newCoursesArr,
            'popular_courses'   => $popularCoursesArr,
        ]);
    }

}