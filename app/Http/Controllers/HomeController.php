<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use App\Services\TeacherService;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Subject;
use App\Models\Role;
use Sentinel;
use App\Models\Contact_us;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;





class HomeController extends Controller
{
    
    /*public function __construct(){
        
        $this->middleware('auth');

        $this->middleare(function($request,$next){
            $this->user=Auth::user(); // here the user should exist from the session
            return $next($request);
        });
    }*/







    //
    public function index()
    {
        
        
        //dd(Sentinel::getUser()->id);


        //$usr= Subject::find(6);
        //dd($usr->creator->id);





        //dd('fcgfdgdfgf');
        $msg = Contact_us::find(1);

        $user = Sentinel::getUser();

        //dd($user::qq1());


        //dump(Auth::user());
        //dd();
        //dd(Gate::allows('is_admin'));
        //dd(Gate::denies('is_admin'));
        //dd($this->authorize('is_admin'));
        
        //dd(User::find(2));

        //$this->authorize('view',$msg);

        //dd($this->authorize('viewAny',User::find(2),$msg));
        //dd($this->authorize('viewAny',Contact_us::class));
        //dd($this->authorize('viewAny','App\Models\Contact_us'));

        //dd($this->authorize('view',$msg));

        //dd($user->can('is_admin'));



        //$usr = User::find($user->id);
        //dd();

        //$msg = Contact_us::find(1);
        //dd($usr->can('is_admin'));




        //$msg = Contact_us::find(1);
        //$this->authorize('view',$msg);





        //dd(auth()->user());


        //$user = Sentinel::getUser();
        //dd($msg);

        //dd($user->can('view', $msg));





        //dd($msg);
        //dd(Auth::user());


        //dd(auth()->user()->can('view',$msg));
        




        //$this->authorize('view');

        //dd(Sentinel::getUser()->isAdmin());


        //Course::groupby('passing_score')->get();


        //load recent teachers
        $teacherService = new TeacherService();
        $teachers       = $teacherService->loadPopularTeachers();

        $courseService  = new CourseService();
        $new_courses        = $courseService->loadNewCourse();

        $popular_courses        = $courseService->loadPopularCourse();

        //dd($popular_courses);


        return view('home')->with([
            'teachers'          => $teachers,
            'new_courses'       => $new_courses,
            'popular_courses'   => $popular_courses,
        ]);




    }




}
