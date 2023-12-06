<?php
namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use Carbon\Carbon;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\Enrollment as EnrollmentModel;
use App\Models\Role as RoleModel;
use App\Models\Course as CourseModel;

use App\Services\CourseService;
use App\View\DataFormatters\CourseDataFormatter;

use App\View\DataFormatters\SubjectDataFormatter;
use DB;
use App\Common\Utils\AlertDataUtil;
use App\Common\SharedServices\UserSharedService;
use App\Repositories\CourseRepository;

use App\Permissions\Abilities\CourseAbilities;
use App\Permissions\Traits\PermissionCheck;
use Symfony\Component\HttpKernel\Exception\HttpException;


class CourseController extends Controller
{
    use PermissionCheck;

    private CourseService $courseService;

    function __construct(CourseService $courseService){
        $this->courseService  = $courseService;
    }


    public function show(?string $slug = null){
        if(!$slug)
            throw new CustomException('Course id not provided');

        $courseData     = $this->courseService->loadCourseData($slug);

        $courseDataArr  = CourseDataFormatter::prepareCourseData($courseData);
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
        return redirect(route('auth.login'))->with(
            AlertDataUtil::warning('Login before enroll the course',[
                //'title' => 'Student Registration submit page',
            ])
        );

    }


    public function watchCourse(?string $slug = null, $videoId = 1){
        if(!$slug)
            throw new CustomException('Course id not provided');

        //todo -need auth and permissions

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
        $subjectsDataArr = SubjectDataFormatter::prepareSubjectDataList($subjects);
        return view('course-search')->with(['subjectData' => $subjectsDataArr]);
    }


    public function submitSearch(Request $request){
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
            return redirect()->route('courses.search')->with(
                AlertDataUtil::error('Search failed !',[
                    'valErrMsgArr'  => $validator->messages()->get('*') ?? []
                    //'message'     => $e->getMessage()
                ])
            );

        $coursesDtoArr  =   $this->courseService->loadSearchResults($request);

        $coursesArr     =   CourseDataFormatter::prepareCoursListData($coursesDtoArr);
        return  redirect(route('courses.search'))
            ->withInput($request->all())
            ->with(['courses' => $coursesArr]);

    }


    public function index(){
        $user       = Sentinel::getUser();

        if ((new UserSharedService)->hasRole($user, RoleModel::STUDENT)) {
            $courses = $this->courseService->loadAllCoursesForStudent($user->id);

        } else {
            $courses = $this->courseService->loadAllCourses();

        }

        $courseDataArr  = CourseDataFormatter::prepareCoursListData($courses);
        return view('all-courses')->with(['all_courses' => $courseDataArr]);
    }


    public function freeEnroll(Request $request){
        $this->hasPermission(CourseAbilities::ENROLL_TO_COURSE);

        $courseId = $request->input('courseId');
        $user     = Sentinel::getUser();

        try{
            if(!filter_var($courseId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');
            
            $courseRec = (new CourseRepository())->findByIdWithGlobalScope($courseId);
            if(is_null($courseRec))
                abort(404, 'Invalid course cannot enroll');

            $this->courseService->freeCourseEnroll($courseRec, $user);
            
            return redirect()->back()->with(AlertDataUtil::success('Successfully enrolled to the course'));

        }catch(CustomException $e){
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Exception $e){
            return redirect()->back()->with(
                AlertDataUtil::error('aa Course does not exist!',[
                    //'message' => $e->getMessage()
                ])
            );
        }
    }


    public function complete(Request $request){
        $courseId = $request->input('courseId');
        $user     = Sentinel::getUser();

        try{
            if(!filter_var($courseId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');
            
            $courseRec = (new CourseRepository())->findByIdWithGlobalScope($courseId);
            if(is_null($courseRec))
                abort(404, 'Invalid course cannot enroll');
            
            $this->hasPermission(CourseAbilities::MARK_COMPLETE, $courseRec);

            $isUpdated = $this->courseService->saveCourseAsComplete($courseRec, $user);
            if(!$isUpdated)
                abort(500, "Failed to mark course as complete due to server error !");

            return redirect()->back()->with(AlertDataUtil::success('Successfully listed course as completed'));

        }catch(CustomException $e){
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Throwable $ex){
            $msg = ($ex instanceof HttpException) ? $ex->getMessage() : 'Unable to mark course as completed !';
            return redirect()->back()->with(
               AlertDataUtil::error($msg, [
                //'message' => $e->getMessage(),
               ])
           );
        }
        

    }


}
