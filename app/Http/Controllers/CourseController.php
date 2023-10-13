<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\Enrollment as EnrollmentModel;
use App\Models\Role as RoleModel;
use App\Models\Course as CourseModel;

use App\Services\CourseService;
use App\View\DataTransformers\CourseDataTransformer;

use App\View\DataTransformers\SubjectDataTransformer;
use DB;

//use App\Repositories\CourseRepository;
//use App\Utils\ColorUtil;
//use Illuminate\Support\Arr;



class CourseController extends Controller
{

    private CourseService $courseService;

    function __construct(CourseService $courseService){
        $this->courseService  = $courseService;
    }


    public function show(?string $slug = null){
        if(!$slug)
            throw new CustomException('Course id not provided');

        $courseData     = $this->courseService->loadCourseData($slug);
        
        $courseDataArr  = CourseDataTransformer::prepareCourseData($courseData);
        $viewFile       = $courseData['viewFile'];

        return view($viewFile)->with([
            'courseData'             => $courseDataArr,

            //'courseContent'          => $courseData['courseContentData']['content'],
            //'courseContentInvFormat' => $courseData['courseContentData']['invalidFormat'],

            'courseContent'          => $courseData['courseContentData']['data'],
            'courseContentInvFormat' => $courseData['courseContentData']['isInvFormat'],


            'bgColor'                => $courseData['colors']['bgColor'],
            'txtColor'               => $courseData['colors']['txtColor'],
            'invColor'               => $courseData['colors']['invColor'],
            'enroll_status'          => $courseData['enroll_status']
        ]);

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


    public function watchCourse(?string $slug = null, $videoId = 1){
        if(!$slug)
            throw new CustomException('Course id not provided');

        $courseData = $this->courseService->loadCourseWatchData($slug, $videoId);
        //$bannerColors = ColorUtil::generateBannerColors($course->image);

        return view('course-watch')->with([
            'courseData'    => $courseData['dto']->toArray(),
            //'bgColor'     => $bannerColors['bgColor'],
            //'txtColor'    => $bannerColors['txtColor'],
            //'invColor'    => $bannerColors['invColor'],
            'videoId'       => $courseData['vid'],
            'sectionId'     => $courseData['sectionId']
        ]);
    }


    public function viewSearchPage(){
        $subjects        = $this->courseService->loadCourseSearchPageData();
        $subjectsDataArr = SubjectDataTransformer::prepareSubjectDataList($subjects);
        return view('course-search')->with(['subjectData'=>$subjectsDataArr]);
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

        if ($validator->fails())
            return redirect()->route('courses.search')->with([
                'message'       => 'Search failed!',
                //'message'     => $e->getMessage(),
                'cls'           => 'flash-danger',
                'msgTitle'      => 'Error!',
                'valErrMsgArr'  => $validator->messages()->get('*') ?? []
            ]);


        $coursesDtoArr  =   $this->courseService->loadSearchResults($request);

        $coursesArr     =   CourseDataTransformer::prepareCoursListData($coursesDtoArr);
        return  redirect(route('courses.search'))
                    ->withInput($request->all())
                    ->with(['courses' => $coursesArr]);

    }


    public function index(){

        $user       = Sentinel::getUser();
        $userRoles  = optional($user)->roles();
        $role       = optional($userRoles)->first();

        if ($user && $role && optional($role)->slug == RoleModel::STUDENT) {
            $courses = $this->courseService->loadAllCoursesForStudent($user->id);
        } else {
            $courses = $this->courseService->loadAllCourses();
        }

        $courseDataArr  = CourseDataTransformer::prepareCoursListData($courses);
        return view('all-courses')->with(['all_courses' => $courseDataArr]);
    }







    /*  ================================================================
        ================================================================= */

    public function freeEnroll(Request $request){

        //dd('ss');
        $courseId = $request->input('courseId');
        $user     = Sentinel::getUser();

        try{
            if(!filter_var($courseId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');
            
            if($user == null)
                throw new CustomException('First login before enrolling');
            
            if(Sentinel::getUser()->roles()->first()->slug != RoleModel::STUDENT)
                throw new CustomException('Invalid user');
            
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


}
