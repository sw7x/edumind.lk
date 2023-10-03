<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Utils\ColorUtil;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\Enrollment as EnrollmentModel;
use App\Models\Role as RoleModel;
use App\Models\Course as CourseModel;

use App\Services\CourseService;


use DB;

class CourseController extends Controller
{

    private CourseService $courseService;


    function __construct(CourseService $courseService){
        $this->courseService  = $courseService;
    }
    

    /*
    public function ViewEnrolledCourse($slug=null){

        try{

            if(!$slug){
                throw new CustomException('Course id not provided');
            }

            //$slug1 = 'non-qui-necessitatibus-magni';
            $course = CourseModel::where('slug', $slug)->first();
            //dd($course);
            if($course != null){

                if($course->status){

                    if($course->image){
                        $img = URL('/').'/storage/'.$course->image;
                    }else{
                        $img = asset('images/default-images/course.png');
                    }

                    $bannerColors = ColorUtil::generateBannerColors($img);
                    //dd($bannerColors);


                    return view('course-single-enrolled')->with([
                        'courseData'    => $course,
                        'bgColor'       => $bannerColors['bgColor'],
                        'txtColor'      => $bannerColors['txtColor'],
                        'invColor'      => $bannerColors['invColor'],
                    ]);
                }else{
                    throw new CustomException('Course is temporary disabled');
                }
            }else{
                throw new CustomException('Course does not exist');
            }
        }catch(CustomException $e){

            return view('course-single-enrolled')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
            return view('course-single-enrolled')->with([
                //'message'     => 'Student does not exist!',
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }
    }
    */



    public function show(?string $slug = null){
        
        try{

            if(!$slug){
                throw new CustomException('Course id not provided');
            }

            $course = CourseModel::where('slug', $slug)->first();
            $currentUser = Sentinel::getUser();            
            $userRole = ($currentUser != null)? $currentUser->roles()->first()->slug : null;
            
            if($course == null){
                throw new CustomException('Course does not exist');
            }

            if($course->status != CourseModel::PUBLISHED){
                throw new CustomException('Course is temporary disabled');
            }
            
            $bannerColors = ColorUtil::generateBannerColors($course->image);

                       
            $pageResult     = $this->courseService->loadCoursePage($currentUser, $course);
            $viewFile       = $pageResult['view'];
            $enroll_status  = $pageResult['status'];

            if($course->price == 0){  $viewFile = 'course-single-enrolled';  }

            //validate course content format
            if(is_array($course->content) && Arr::isAssoc($course->content)){
                $courseContent          = $course->content;
                $courseContentInvFormat = false;
            }else{
                $courseContent = [];
                $courseContentInvFormat = true;
            }

            return view($viewFile)->with([
                'courseData'             => $course,                        
                'courseContent'          => $courseContent,
                'courseContentInvFormat' => $courseContentInvFormat,
                'bgColor'                => $bannerColors['bgColor'],
                'txtColor'               => $bannerColors['txtColor'],
                'invColor'               => $bannerColors['invColor'],
                'enroll_status'          => ($enroll_status  ?? "")
            ]);

            
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('course-single-before-enrolled');

        }catch(\Exception $e){

            //session()->flash('message', 'Failed to show course');
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error ');
            return view('course-single-before-enrolled');
        }

    }

    public function guestEnroll(){

        return redirect(route('auth.login'))->with([
            'message'   => 'Login before enroll the course',
            //'message2' => $pwResetTxt,
            //'title'   => 'Student Registration submit page',
            'cls'       => 'flash-warning',
            'msgTitle'  => 'Warning!',
        ]);
    }

    


    

    public function freeEnroll(Request $request){

        //dd('ss');
        $courseId = $request->input('courseId');
        $user     = Sentinel::getUser();

        try{
            if(!filter_var($courseId, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }

            if($user == null){
                throw new CustomException('First login before enrolling');
            }

            if(Sentinel::getUser()->roles()->first()->slug != RoleModel::STUDENT){
                throw new CustomException('Invalid user');
            }

            $course = CourseModel::find($courseId);

            if($course != null){
                     
                $rec = CourseSelectionModel::create([
                    'cart_added_date'   => null,
                    'is_checkout'       => false,
                    'course_id'         => $courseId,
                    'student_id'        => $user->id
                ]);               

                EnrollmentModel::create([
                    'is_complete'           => 0,
                    'course_selection_id'   => $rec->id,
                ]);
                
                return redirect()->back()->with([
                    'message'     => 'Successfully enrolled to the course',
                    'cls'         => 'flash-success',
                    'msgTitle'    => 'Success !',
                ]);

            }else{
                throw new ModelNotFoundException;
            }
        }catch(CustomException $e){

            return redirect()->back()->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){

            return redirect()->back()->with([
                //'message'     => $e->getMessage(),
                'message'     => 'Course does not exist!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }
    }


    public function complete(Request $request){

        $courseId = $request->input('courseId');
        $user     = Sentinel::getUser();

        try{
            if(!filter_var($courseId, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }

            if($user == null){
                throw new CustomException('First login before enrolling');
            }

            if(Sentinel::getUser()->roles()->first()->slug != RoleModel::STUDENT){
                throw new CustomException('Invalid user');
            }

            $course = CourseModel::find($courseId);

            if($course != null){

                
                $CourseSelectionRecord = CourseSelectionModel::where('course_id',$course->id)->where('student_id',$user->id)->get()->first();
                   
                $enrollmentRecord   = EnrollmentModel::where('course_selection_id', $CourseSelectionRecord->id)->get()->first();
                $enrollmentRecord->is_complete      = True;
                $enrollmentRecord->complete_date    = Carbon::now();
                $enrollmentRecord->save();

                return redirect()->back()->with([
                    'message'     => 'Successfully listed course as completed',
                    'cls'         => 'flash-success',
                    'msgTitle'    => 'Success !',
                ]);

            }else{
                throw new ModelNotFoundException;
            }
        }catch(CustomException $e){

            return redirect()->back()->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){

            return redirect()->back()->with([
                'message'     => $e->getMessage(),
                //'message'     => 'Course does not exist!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }

    }



    public function watchCourse_hor(){
        return view('course-watch-hor');
    }



    public function watchCourse($slug=null,$videoId=1){

        //$slug ='libero-laboriosam-minus-est-necessitatibus-aut';
        //return abort(404); //todo

        try{

            if(!$slug){
                throw new CustomException('Course id not provided');
            }

            //$slug1 = 'non-qui-necessitatibus-magni';
            $course = CourseModel::where('slug', $slug)->first();
            //dd($course);
            if($course != null){

                if($course->status){

                    $bannerColors = ColorUtil::generateBannerColors($course->image);
                    //dd($bannerColors);
                    //dump($course->getlinkCount());

                    $vid        = ($videoId > 0 && $videoId <= $course->getLinkCount())?intval($videoId):1;
                    $sectionId  = $course->getVideoSectionId($vid);
                    //dd($vid);

                    /*
                    $course->getVideoSectionId(0);
                    $course->getVideoSectionId(1);
                    $course->getVideoSectionId(20);
                    */

                    //dd($course->name);
                    return view('course-watch')->with([
                        'courseData'    => $course,
                        //'bgColor'       => $bannerColors['bgColor'],
                        //'txtColor'      => $bannerColors['txtColor'],
                        //'invColor'      => $bannerColors['invColor'],
                        'videoId'       => $vid,
                        'sectionId'    => $sectionId
                    ]);

                }else{
                    throw new CustomException('Course is temporary disabled');
                }
            }else{
                throw new CustomException('Course does not exist');
            }
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('course-single-before-enrolled');
        
        }catch(\Exception $e){
            //dd($e->getMessage());
            session()->flash('message', 'Failed to load course');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('course-single-before-enrolled');
            
        }

    }


    public function viewSearchPage(){

        $subjects = \App\Models\Subject::all();        
        $arr = array();    

        $subjects->map(function ($item) use (&$arr){  
            $arr[] = array(
                'name' =>$item->name,
                'id'   =>$item->id
            );
        });

        //dd($arr);
        return view('course-search')->with(['subjectData'=>$arr]);
    }


    public function SearchCourse(Request $request){
                
        $validator = Validator::make($request->all(), [
            'subject'           =>  'numeric|nullable',
            'course-type'       =>  'required|in:free,paid',
            'course-duration'   =>  'required|in:short,medium,long,very-long'            
        ],[
            'subject.numeric'           =>  'subject is invalid',          
            'course-type.required'      =>  'Course type is required',
            'course-type.in'            =>  'Course type is invalid',
            'course-duration.required'  =>  'Course duration is required',
            'course-duration.in'        =>  'Course duration is invalid'          
        ]);

        if ($validator->fails()) {
            return redirect()->route('courses.search')->with([
                'message'       => 'Search failed!',
                //'message'     => $e->getMessage(),                    
                'cls'           => 'flash-danger',
                'msgTitle'      => 'Error!',
                'valErrMsgArr'  => $validator->messages()->get('*') ?? []
            ]);            
        } else {
            
            $subjectId      = $request->get('subject');
            $courseType     = $request->get('course-type');
            $courseName     = $request->get('searchQueryInput');
            $courseDuration = $request->get('course-duration');       

            //dump('%'.$courseName.'%');
            //DB::enableQueryLog();
                    
                     

            $courses =  CourseModel::join('subjects','courses.subject_id','=','subjects.id')                    
                        ->where(function ($query) use($courseType, $subjectId, $courseName) { 
                    
                            if($courseName){
                                $query->where('courses.name','like','%'.$courseName.'%');  
                            }                                

                            if($subjectId){
                                $query->where('courses.subject_id', '=', $subjectId);
                            }                                   
                                
                        
                            if($courseType == 'free'){
                                $query->where('courses.price', 0);
                            }else{
                                $query->where('courses.price', '>',0);
                            }

                            $query->where('subjects.status', '=', \App\Models\Subject::PUBLISHED);
                            //->where('courses.status', 'published');                  
                    
                        })->where(function ($query) use($courseDuration) { 

                            if($courseDuration == 'short'){
                               // 0-1 Hour 
                                $query->where('courses.duration', 'LIKE', '~0 Hours :%')
                                ->where('courses.duration', 'LIKE', '%minute%');                                  
                            
                            }elseif ($courseDuration == 'medium') {                                    
                                // 1-3 Hour
                                $query->where('courses.duration', 'LIKE', '1 Hour :%')
                                    ->orWhere('courses.duration', 'LIKE', '2 Hours :%');

                            }elseif ($courseDuration == 'long') {
                                // 3-6 Hours
                                $query->where('courses.duration', 'LIKE', '3 Hours :%')
                                    ->orWhere('courses.duration', 'LIKE', '4 Hours :%')
                                    ->orWhere('courses.duration', 'LIKE', '5 Hours :%');

                            }elseif ($courseDuration == 'very-long') {
                                // 6+ Hours
                                $query->where('courses.duration', 'LIKE', '%Hours :%')
                                   ->where('courses.duration', 'NOT LIKE', '0 Hours :%')
                                   ->where('courses.duration', 'NOT LIKE', '2 Hours :%')
                                   ->where('courses.duration', 'NOT LIKE', '3 Hours :%')
                                   ->where('courses.duration', 'NOT LIKE', '4 Hours :%')
                                   ->where('courses.duration', 'NOT LIKE', '5 Hours :%')
                                   ->where('courses.duration', 'NOT LIKE', '1 Hour :%');                                 
                            }else{

                            }  

                        })
                        //->toSql();                    
                        ->get('courses.*');    

                        //dd($courses->toArray());                      
                        
                        //dump(DB::getQueryLog());
                        //dd($courses->pluck('name','id')->toArray());                        
          
        }
 
        return redirect(route('courses.search'))
            ->withInput($request->all())
            ->with([
                //'subjectData'   =>  $arr,
                'courses'       =>  $courses
            ]);

    }


    public function index(){    

        try{

            $user = Sentinel::getUser();
            
            if($user != null && ($user->roles()->first()->slug == RoleModel::STUDENT)){                               
                $courses = $this->courseService->loadAllCourses($user->id);
            }else{
                $courses = CourseModel::all();
            }

            /*
            dump($courses);

            foreach ($courses as $course) {
                $id = optional($course->teacher)->id;
                
                //dump($course);
                dump($id);
                if(is_null($id))
                    dump($course);

                dump('===========');


                //dump($course->teacher->username);
            }
            dd('__');
            */

            //$courses = $this->courseService->loadAllCourses($user->id);
            //dd($courses);
            return view('all-courses')->with(['all_courses' => $courses]);

        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('all-courses');

        }catch(\Exception $e){
            dd($e->getMessage());
            session()->flash('message', 'Failed to load your courses');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('all-courses');

        }
    }    
    





    

}
