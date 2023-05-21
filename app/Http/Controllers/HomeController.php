<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use App\Services\TeacherService;
use Illuminate\Http\Request;


/* for testing todo - later remove*/
use App\Models\User;
use App\Models\Subject;
use App\Models\Role;
use Sentinel;
use App\Models\Contact_us;
use App\Models\CourseSelection;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Course;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;






use Illuminate\Support\Collection;
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
    public function cindex(){
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
    


    public function index()
    {
        
        //$seeder = new \Database\Seeders\InvalidItemsInCart();
        //$seeder->run();

                

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


