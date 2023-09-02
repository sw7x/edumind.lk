<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use Sentinel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Models\Enrollment as EnrollmentModel;


use App\Repositories\ABCls;
use Illuminate\Support\Facades\App;


class HomeController extends Controller
{
    
    /*public function __construct(){
        
        $this->middleware('auth');

        $this->middleare(function($request,$next){
            $this->user=Auth::user(); // here the user should exist from the session
            return $next($request);
        });
    }*/

    
    // for testing
    public function index(){



        //load recent teachers
        $teacherService = new TeacherService();
        $teachers       = $teacherService->loadPopularTeachers();

        $courseService  = new CourseService();
        $new_courses        = $courseService->loadNewCourse();

        $popular_courses        = $courseService->loadPopularCourse();

        //dd($popular_courses->toArray());

        return view('home')->with([
            'teachers'          => $teachers,
            'new_courses'       => $new_courses,
            'popular_courses'   => $popular_courses,
        ]);
    }
    


    

}

