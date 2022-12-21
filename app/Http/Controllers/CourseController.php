<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Course;
use App\Utils\ColorUtil;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sentinel;
use Illuminate\Http\Request;

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

                if($course->status){

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
                                $viewFile = 'course-single-free';
                            }

                        }else if($userRole == 'student'){
                            $isEnrolled = $currentUser->enrolled_courses()->where('course_id', $course->id)->first();

                            if($isEnrolled != null){
                                $enrolled_status = $isEnrolled->pivot->status;

                                if($enrolled_status == 'enrolled' || $enrolled_status == 'completed'){
                                    $viewFile = 'course-single-enrolled';
                                }else{
                                    $viewFile = 'course-single-free';
                                }
                            }else{
                                $viewFile = 'course-single-free';
                            }

                        }else{
                            $viewFile = 'course-single-free';
                        }
                    }else{
                        $viewFile = 'course-single-free';
                    }

                    if($course->price==0){
                        $viewFile = 'course-single-enrolled';
                    }

                    return view($viewFile)->with([
                        'courseData'      => $course,
                        'bgColor'         => $bannerColors['bgColor'],
                        'txtColor'        => $bannerColors['txtColor'],
                        'invColor'        => $bannerColors['invColor'],
                        'enrolled_status' => ($enrolled_status = $enrolled_status ?? "")
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
            return view('course-single-free');

        }catch(\Exception $e){
            session()->flash('message', 'Failed to show course');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error ');
            return view('course-single-free');
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
            return view('course-single-free');
        
        }catch(\Exception $e){
            //dd($e->getMessage());
            session()->flash('message', 'Failed to load course');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('course-single-free');
            
        }

    }


}
