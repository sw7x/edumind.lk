<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Course;
use App\Utils\ColorUtil;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

use DB;
//use App\Models\Subject;

class CourseController extends Controller
{

    /*
    public function ViewEnrolledCourse($slug=null){

        try{

            if(!$slug){
                throw new CustomException('Course id not provided');
            }

            //$slug1 = 'non-qui-necessitatibus-magni';
            $course = Course::where('slug', $slug)->first();
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



    public function ViewCourse($slug=null){
        
        try{

            if(!$slug){
                throw new CustomException('Course id not provided');
            }

            //$slug1 = 'non-qui-necessitatibus-magni';
            $course = Course::where('slug', $slug)->first();
            $currentUser = Sentinel::getUser();

            //dd($currentUser);
            //dd($currentUser->roles()->first()->slug);
            //dd(Sentinel::check());

            if($currentUser != null){
                $userRole = $currentUser->roles()->first()->slug;
            }else{
                $userRole = null;
            }

            //=cart add=
            /*
            $currentUser->enrolled_courses()->attach(7, [
                'cart_add_date' => Carbon::now(),
                'status'        => 'cart_added',
            ]);
            */


            //=enroll=
            //discount_amount - todo
            /*$update_rows = $currentUser->enrolled_courses()->updateExistingPivot(9, [
                'enroll_date'       => Carbon::now(),
                'status'            => 'enrolled',
                'discount_amount'   => 0
            ], true);
            //if there is nor rows to update then insert new row
            if($update_rows == 0) {
                $currentUser->enrolled_courses()->attach(9, [
                    'enroll_date'       => Carbon::now(),
                    'status'            => 'enrolled',
                    'discount_amount'   => 0
                ]);
            }*/

            //=complete=
            //complete_date
            //status
            /*$currentUser->enrolled_courses()->updateExistingPivot(7, [
                'enroll_date'       => Carbon::now(),
                'status'            => 'completed',
                'discount_amount'   => 0
            ], true);
            */
            
            

            if($course != null){

                if($course->status == Course::PUBLISHED){

                    if($course->image){
                        $img = URL('/').'/storage/'.$course->image;
                    }else{
                        $img = asset('images/default-images/course.png');
                    }

                    $bannerColors = ColorUtil::generateBannerColors($img);



                    if($currentUser){

                        if($userRole == 'teacher'){
                            $isAuthor = $course->teacher()->where('id', $currentUser->id)->first();
                            
                            if($isAuthor){
                                $viewFile = 'course-single-enrolled';
                            }else{
                                $viewFile = 'course-single-before-enrolled';
                            }

                        }else if($userRole == 'student'){

                            //------------------///////////////////---------------------------------------///                          
                            $courseSelection = $currentUser->course_selections()->where('course_id', $course->id)->first();
                            //dump($courseSelection);
                            //dd('courseSelection');
                            
                            if($courseSelection != null){                                

                                if($courseSelection->is_checkout){                                    
                                    
                                    $enrollment = $courseSelection->enrollment()->first();
                                    
                                    if($enrollment){
                                        if($enrollment->is_complete){                                      
                                            $enroll_status  = 'COMPLETED';  // ---> COMPLETE COURSE
                                            $viewFile       = 'course-single-enrolled';
                                        }else{
                                            $enroll_status  = 'ENROLLED';  // ---> COMPLETE COURSE
                                            $viewFile       = 'course-single-enrolled';
                                        }
                                    }else{

                                        /*
                                            $courseSelection->is_checkout =true
                                            $enrollment = null

                                            if enrollment record is not there for courseSelection record
                                            then update courseSelection.is_checkout to 0
                                        */
                                        $courseSelection->is_checkout = false;
                                        $courseSelection->save();

                                        $enroll_status  = 'ADDED_TO_CART';   //---> view cart
                                        $viewFile       = 'course-single-before-enrolled';

                                    }                     

                                }else{
                                    $enroll_status  = 'ADDED_TO_CART';   //---> view cart
                                    $viewFile       = 'course-single-before-enrolled';
                                }                               

                            }else{
                                $enroll_status  = 'START';   //---> add to cart
                                $viewFile       = 'course-single-before-enrolled';
                            }
                            //------------------///////////////////---------------------------------------///
                        
                        }
                        else if($userRole == 'editor'){
                            $viewFile = 'course-single-enrolled';
                        }else if($userRole == 'admin'){
                            $viewFile = 'course-single-enrolled';
                        }else if($userRole == 'marketer'){
                            $viewFile = 'course-single-before-enrolled';
                        }else{
                            $viewFile = 'course-single-before-enrolled';
                        }
                        
                    }else{
                        $viewFile       = 'course-single-before-enrolled';
                    }

                    
                    if($course->price==0){
                        $viewFile = 'course-single-enrolled';
                    }


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

    public function enroll(Request $request){

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

            if(Sentinel::getUser()->roles()->first()->slug != 'student'){
                throw new CustomException('Invalid user');
            }

            $course = Course::find($courseId);

            if($course != null){

                //fill enrollment table
                $user->enrolled_courses()->attach($course,[
                    'status'        => 'enrolled',
                    'enroll_date'   =>  now()
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

            if(Sentinel::getUser()->roles()->first()->slug != 'student'){
                throw new CustomException('Invalid user');
            }

            $course = Course::find($courseId);

            if($course != null){

                //update enrollment status
                $update_rows = $user->enrolled_courses()->updateExistingPivot($course, [
                    'complete_date'     => Carbon::now(),
                    'status'            => 'completed',
                ], true);

                //if there is no rows to update then insert new row
                if($update_rows == 0) {
                    $user->enrolled_courses()->attach($course, [
                        'complete_date'     => Carbon::now(),
                        'status'            => 'completed',
                    ]);
                }

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
                'message'     => 'Course does not exist!',
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
            $course = Course::where('slug', $slug)->first();
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

        $subjects = \App\Models\Subject::Where('status', \App\Models\Subject::PUBLISHED)->get();
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
            return redirect()->route('course-search')->with([
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
                    
                     

            $courses =  Course::join('subjects','courses.subject_id','=','subjects.id')                    
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

                            $query->where('subjects.status', '=', \App\Models\Subject::PUBLISHED)
                                ->where('courses.status', 'published');                          
                    
                        })->where(function ($query) use($courseDuration) { 

                            if($courseDuration == 'short'){
                               // 0-1 Hour 
                                $query->where('courses.duration', 'LIKE', '0 Hours :%')
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
                        
                        //dump(DB::getQueryLog());
                        //dd($courses->pluck('name','id')->toArray());                        
          
        }
 
        return redirect(route('course-search'))
            ->withInput($request->all())
            ->with([
                //'subjectData'   =>  $arr,
                'courses'       =>  $courses
            ]);

    }

}

