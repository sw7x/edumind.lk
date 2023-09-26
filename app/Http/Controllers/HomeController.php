<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use App\Services\TeacherService;
use App\View\DataTransformers\HomePageDataTransformer;

/*
use Illuminate\Http\Request;
use Sentinel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
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

        //dd('hh');

        return view('home')->with([
            'teachers'          => $teachersArr,
            'new_courses'       => $newCoursesArr,
            'popular_courses'   => $popularCoursesArr,
        ]);
    }





}






?>
