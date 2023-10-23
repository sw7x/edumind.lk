<?php
namespace App\Services;

use App\Repositories\CourseRepository;
use App\Repositories\SubjectRepository;

//use App\Builders\CourseBuilder;
//use App\Builders\SubjectBuilder;
use Illuminate\Support\Arr;
use Sentinel;
use App\Common\Utils\ColorUtil;

use App\Models\Course as CourseModel;
use App\Models\Role as RoleModel;
use App\Models\Subject as SubjectModel;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Common\SharedServices\CourseSharedService;
//use Illuminate\Support\Str;
use App\DataTransformers\Database\CourseDataTransformer;
use App\DataTransformers\Database\SubjectDataTransformer;
use App\Common\SharedServices\UserSharedService;


class CourseService
{

    private CourseRepository $courseRepository;

    function __construct(CourseRepository $courseRepository){
        $this->courseRepository = $courseRepository;
    }

    public function findDbRec(int $id) : ?array {
        $dbRec = $this->courseRepository->findById($id);
        if(is_null($dbRec))
            abort(404,'Course does not exist');

        $dto = $dbRec ? CourseDataTransformer::buildDto($dbRec->toArray()) : null;
        return array(
            'dbRec' => $dbRec,
            'dto'   => $dto
        );
    }

    public function loadCourseData(string $slug) : array {

        $courseRec = $this->courseRepository->findByUrl($slug);
        if(is_null($courseRec))
            abort(404, 'Course does not exist');

        if($courseRec->status != CourseModel::PUBLISHED)
            throw new CustomException('Course is temporary disabled');

        $bannerColors   = ColorUtil::generateBannerColors($courseRec->image);

        $currentUser    = Sentinel::getUser();
        $pageResult     = $this->loadCoursePage($currentUser, $courseRec);
        $viewFile       = $pageResult['view'];

        if($courseRec->price == 0)
            $viewFile = 'course-single-enrolled';

        //validate course content format
        $courseContentData  =  (new CourseSharedService())->validateCourseContent($courseRec->content);

        $courseDto          = CourseDataTransformer::buildDto($courseRec->toArray());

        return array(
            'dto'               => $courseDto,
            'dbRec'             => $courseRec,
            'courseContentData' => $courseContentData,
            'colors'            => $bannerColors,
            'viewFile'          => $viewFile,
            'enroll_status'     => ($pageResult['status']  ?? "")
        );
    }


    public function loadCourseWatchData(string $slug, $videoId) : array {
        $courseRec = $this->courseRepository->findByUrl($slug);
        if(is_null($courseRec))
            abort(404, 'Course does not exist');

        if($courseRec->status != CourseModel::PUBLISHED)
            throw new CustomException('Course is temporary disabled');

        $courseEntity   = CourseDataTransformer::buildEntity($courseRec->toArray());

        //if invalid video id is given in url then load first video
        $videoId        = is_numeric($videoId) ? intval($videoId) : 1;
        $vid            = ($videoId > 0 && $videoId <= $courseEntity->getLinkCount()) ? $videoId : 1;
        $sectionId      = $courseEntity->getVideoSectionId($vid);

        $courseDto      = CourseDataTransformer::buildDto($courseRec->toArray());

        return array(
            'dto'       => $courseDto,
            'dbRec'     => $courseRec,
            'vid'       => $vid,
            'sectionId' => $sectionId
        );

    }


    public function loadCourseSearchPageData(){
        $subjecRecs = (new SubjectRepository())->allWithGlobalScope();

        $dataArr = array();
        $subjecRecs->each(function (SubjectModel $record, int $key) use (&$dataArr){
            $dataArr[] = SubjectDataTransformer::buildDto($record->toArray());
        });
        return $dataArr;
    }


    public function loadNewCourses(){
        $courseCount    = 10;
        $newCourses     = $this->courseRepository->getNewCourse($courseCount);

        $dataArr = array();
        $newCourses->each(function (CourseModel $record, int $key) use (&$dataArr){
            $dataArr[]  =   CourseDataTransformer::buildDto($record->toArray());
        });
        return $dataArr;
    }


    public function loadPopularCourses(){
        $courseCount    = 5;
        $popularCourses = $this->courseRepository->getPopularCourses($courseCount);
        
        $dataArr = array();
        $popularCourses->each(function (CourseModel $record, int $key) use (&$dataArr){
            $dataArr[]  =   CourseDataTransformer::buildDto($record->toArray());
        });
        return $dataArr;
    }



    /*
    for student
        when status = FRESH          then display [add to cart] button
        when status = ADDED_TO_CART  then display [view cart] button
        when status = ENROLLED       then display [complete course] button
        when status = COMPLETED      then display 'course completed' messeage
    */
    private function loadCoursePage(?UserModel $user, CourseModel $courseRec) : array {
        $usrSvc = new UserSharedService();

        if($usrSvc->hasRole($user, RoleModel::STUDENT)){
            $courseSelection = $user->course_selections()->where('course_id', $courseRec->id)->first();

            if(is_null($courseSelection)){
                // not added to cart
                $viewFile   = 'course-single-before-enrolled';
                $status     = 'FRESH';

            }else{
                $enrollment         = $courseSelection->enrollment()->first();
                $isCourseComplete   = optional($enrollment)->is_complete;

                if($courseRec->price == 0){
                    /*  in free course is_checkout = 0
                        free course always have relevant enrollment record in enrollments table  */
                    $viewFile   =  'course-single-enrolled';
                    $status     =  $isCourseComplete ? 'COMPLETED' : 'ENROLLED';

                }else{
                    /*  in paid course is_checkout = 1 (only in paid course)
                        in paid courses if is_checkout = 1 then there is always have enrollment record */
                    if($courseSelection->is_checkout){

                        /*  if  $courseSelection->is_checkout = 1, and no enrollment record
                                then to fix error update courseSelection.is_checkout to 0   */
                        if (!$enrollment)
                            $courseSelection->update(['is_checkout' => false]);

                        $viewFile   =   ($enrollment) ? 'course-single-enrolled' : 'course-single-before-enrolled';
                        $status     =   ($enrollment) ? ($isCourseComplete ? 'COMPLETED' : 'ENROLLED') : 'ADDED_TO_CART';

                    }else{
                        $viewFile   = 'course-single-before-enrolled';
                        $status     = 'ADDED_TO_CART';
                    }
                }
            }

        }elseif ($usrSvc->hasRole($user, RoleModel::TEACHER)){
            $isAuthor   = $courseRec->teacher()->where('id', $user->id)->first();
            $viewFile   = ($isAuthor) ? 'course-single-enrolled' : 'course-single-before-enrolled';
            $status     =  null;

        }elseif ($usrSvc->hasRole($user, RoleModel::MARKETER)){
            $viewFile   = 'course-single-before-enrolled';
            $status     =  null;

        }elseif ($usrSvc->hasRole($user, RoleModel::EDITOR)){
            $viewFile   = 'course-single-enrolled';
            $status     =  null;

        }elseif ($usrSvc->hasRole($user, RoleModel::ADMIN)){
            $viewFile   = 'course-single-enrolled';
            $status     =  null;

        }else{
            // for guests and invalid user roles
            $viewFile   = 'course-single-before-enrolled';
            $status     =  null;
        }

        return array('view' => $viewFile, 'status' => $status);
    }



    /*
        1. course is not added to user's cart then enrollments_status = 'FRESH'
        2. course is already added to user's cart and not enrolled then enrollments_status = 'ADDED_TO_CART'
        3. enrolled to course still not marked as completed then enrollments_status = 'ENROLLED'
        4. enrolled to course and marked as completed then enrollments_status = 'COMPLETED'
    */
    public function loadAllCoursesForStudent(int $studentId): array {
        $courses = $this->courseRepository->allWithGlobalScope();

        return $courses->map(function (CourseModel $courseRec) use ($studentId) {
            $courseSelRec   = $courseRec->course_selections()->where('student_id', $studentId)->first();
            $status         = 'FRESH';
            $enrollment     = optional($courseSelRec)->enrollment;

            if ($courseSelRec)
                $status =   $enrollment ? 
                                ($enrollment->is_complete ? 'COMPLETED' : 'ENROLLED') : 
                                'ADDED_TO_CART';

            return array(
                'dto'                => CourseDataTransformer::buildDto($courseRec->toArray()),
                'dbRec'              => $courseRec,
                'enrollments_status' => $status,
            );

        })->toArray();
    }


    public function loadAllCourses(){
        $allCourses = $this->courseRepository->allWithGlobalScope();
        $courseArr  = array();

        $allCourses->map(function (CourseModel $item) use (&$courseArr){
            $tempArr            = array();
            $tempArr['dto']     = CourseDataTransformer::buildDto($item->toArray());
            $tempArr['dbRec']   = $item;
            $courseArr[]        = $tempArr;
        });
        return $courseArr;
    }


    public function loadSearchResults(Request $request){
        $searchParams = $request->only(['subject', 'course-type', 'searchQueryInput', 'course-duration']);
        $courses      = $this->courseRepository->getSearchCourses($searchParams);

        $coursesDtoArr = array();
        $courses->each(function (CourseModel $record, int $key) use (&$coursesDtoArr){
            $tempArr            = array();

            $tempArr['dto']     = CourseDataTransformer::buildDto($record->toArray());
            $tempArr['dbRec']   = $record;

            $coursesDtoArr[]    = $tempArr;
        });
        return $coursesDtoArr;

    }



}



//service only methods - not in entity

    //view courses  by teacher               ==>view my courses (t)
    //view all the courses by subject
    // enrolled courses by stud


    // getEnrollStudents
    // getCompleteStudents

    //viewCourseRating(Course $c)



//methods - also in entity
    //change course status


