<?php


namespace App\Services;


use App\Repositories\CourseRepository;


use App\Models\Course as CourseModel;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Builders\CourseBuilder;
class CourseService
{    
    
    private CourseRepository $courseRepository;

    function __construct(CourseRepository $courseRepository){
        $this->courseRepository = $courseRepository;
    }


    public function loadNewCourses(){
        $courseCount    = 10;
        $newCourses     = $this->courseRepository->getNewCourse($courseCount);
        
        $dataArr = array();
        $newCourses->each(function (CourseModel $record, int $key) use (&$dataArr){
            $dataArr[]  =   CourseBuilder::buildDto($record->toArray());
        });
        return $dataArr;
    }

    


    public function loadPopularCourses(){
        $courseCount    = 5;
        $popularCourses = $this->courseRepository->getPopularCourses($courseCount);
        $dataArr = array();
        $popularCourses->each(function (CourseModel $record, int $key) use (&$dataArr){
            $dataArr[]  =   CourseBuilder::buildDto($record->toArray());
        });
        return $dataArr;     
    }



    /*
    public function checkUsernameExists($username){
        return User::where('username',$username)->get()->count();
    }

   public function getlinkCount($data){
        return User::where('username',$username)->get()->count();
    }
    */

    


    public function loadCoursePage($currentUser, $course){

        if(!$currentUser){
            return array(
                'view'      => 'course-single-before-enrolled',
                'status'    =>  null
            );            
        }
        
        $userRole = ($currentUser != null)? $currentUser->roles()->first()->slug : null;
        
        /* ==== teacher ====*/
        if($userRole == Role::TEACHER){
            $isAuthor = $course->teacher()->where('id', $currentUser->id)->first();                            
            $viewFile = ($isAuthor)? 'course-single-enrolled' : 'course-single-before-enrolled';            
        }

        //dump($course->id);


        /* ==== student ====*/
        if($userRole == Role::STUDENT){
            $courseSelection = $currentUser->course_selections()->where('course_id', $course->id)->first();                                
            //dd($courseSelection);
            if($courseSelection == null){ 
                // not added to cart 
                $enroll_status  = 'FRESH';   //---> display [add to cart] button
                $viewFile       = 'course-single-before-enrolled';
            }else{

                $enrollment = $courseSelection->enrollment()->first();                              
                //dump($enrollment);
                
                if($course->price == 0){

                    /* ========  free courses =========== */
                    // is_checkout = 0 in free course
                    // in free courses then there is always have relevant enrollment record in enrollments table
                    $enroll_status = ($enrollment->is_complete) ? 'COMPLETED' : 'ENROLLED';
                    $viewFile       = 'course-single-enrolled';

                }else{
                    
                    /* ========  paid courses =========== */
                    // is_checkout = 1 happens only in paid course
                    // if is_checkout = 1 then in paid courses then there is always have relevant enrollment record in enrollments table
                    if($courseSelection->is_checkout){                        
                                                
                        if($enrollment){

                            $enroll_status = ($enrollment->is_complete) ? 'COMPLETED' : 'ENROLLED';                       
                            $viewFile       = 'course-single-enrolled';
                        }else{
                                                                                      
                            //if $courseSelection->is_checkout = 1, $enrollment = null then to fix Error
                            //update courseSelection.is_checkout to 0                            
                            $courseSelection->is_checkout = false;
                            $courseSelection->save();

                            $enroll_status  = 'ADDED_TO_CART'; //---> [view cart]
                            $viewFile       = 'course-single-before-enrolled';
                        }

                    }else{ 

                        $enroll_status  = 'ADDED_TO_CART'; //---> [view cart]
                        $viewFile       = 'course-single-before-enrolled';
                    }
                }
                
            }
        }



        /* ==== editor ====*/
        if($userRole == Role::EDITOR){  $viewFile = 'course-single-enrolled';  }

        /* ==== admin ====*/
        if($userRole == Role::ADMIN){  $viewFile = 'course-single-enrolled';  }

        /* ==== marketer ====*/
        if($userRole == Role::MARKETER){  $viewFile = 'course-single-before-enrolled';  }
                
        /* ==== if unknown user role ====*/
        $viewFile = $viewFile ?? 'course-single-before-enrolled';                      
           
        
        return array(
            'view'      => $viewFile,
            'status'    => $enroll_status ?? null
        );

    }


    public function loadAllCourses($userId){

        $allCourses = Course::all();
        $courseArr = array();        
        
        $allCourses->map(function ($item) use (&$courseArr, $userId){ 
            
                   
            $courseSelRec = $item->course_selections()->where('student_id',$userId)->first();
            
            if($courseSelRec){

                $enrollment = $courseSelRec->enrollment;                
                if($enrollment){

                    if(!$enrollment->is_complete){
                        //dump('Course [' . $item->id . '-' . $item->name . '] enrolled by user '. $userId);
                        $enrollmentsStatus = 'ENROLLED';
                    }else{
                        //dump('Course [' . $item->id . '-' . $item->name . '] completed by user '. $userId);
                        $enrollmentsStatus = 'COMPLETED';
                    }
                }else{
                    //dump('Course [' . $item->id . '-' . $item->name . '] added to cart by user '. $userId); 
                    $enrollmentsStatus = 'ADDED_TO_CART';                   
                }
            }else{            
                //dump('Course [' . $item->id . '-' . $item->name . '] not touched by user '. $userId);
                $enrollmentsStatus = 'FRESH'; 
            }
            
            $courseArr[] = (object)array(
                'id'            => $item->id,
                'name'          => $item->name,
                'heading_text'  => $item->heading_text,
                'image'         => $item->image,
                'slug'          => $item->slug,
                'price'         => $item->price,
                'video_count'   => $item->video_count,
                'duration'      => $item->duration,

                'teacher_username'  => $item->teacher->username,
                'teacher_fullname'  => $item->teacher->full_name,

                'enrollments_status'    => $enrollmentsStatus
            );            
        }); 
        
        //dump(Course::all());
        //dump($courseArr);
        //dump(collect($courseArr));
        //dd();

        return collect($courseArr);
    }  


    /* this is dummy method */
    public function dummyMethod(CourseDto $courseDto){
        
        //DB ===> entity
        $courseModel = Course::findById(7);
        $courseEntityDataArr = (new CourseRepository())->getEntityStructuredDbData($courseModel);
        $courseEntity = $this->hydrateCourseData($courseEntityDataArr);




        //entity     ===> DB
        $dbStructuredDataSet = (new CourseRepository())->getDbStructuredEntityData($courseEntity);
        //eloquent inser.delete,select,update


        //dto
            //$courseDto
                //(new CourseRepository())->findById($courseDto->id)                
                //(new CourseRepository())->create($courseDto)
                //(new CourseRepository())->update($courseDto->id,$courseDto)
                //(new CourseRepository())->deleteById($courseDto->id)

            //$courseDtoArr
                /*
                $ids = array_map(function ($obj) {
                    return $obj->id;
                }, $courseDtoArr);
                //$ids = Arr::pluck($courseDataArr, 'id');            

                (new CourseRepository())->findManyByIds($ids)
                */


        //return new UserDto($user->id, $user->name, $user->email, $user->password);
        
        

        $courseModel         = Course::find($courseDto->id);
        $courseEntityDataArr = (new CourseRepository())->getEntityStructuredDbData($courseModel);
        $courseEntity        = (new CourseRepository())->hydrateCourseData($courseEntityDataArr);

        $subjectModel          = Subject::find($courseDto->subjectId);
        $subjectEntityDataArr  = (new SubjectRepository())->getEntityStructuredDbData($subjectModel);
        $subjectEntity         = (new SubjectRepository())->hydrateSubjectData($subjectEntityDataArr);

        $teacherModel           = User::find($courseDto->teacherId);
        $teacherEntityDataArr   = (new UserRepository())->getEntityStructuredDbData($teacherModel);
        $teacherEntity          = (new UserRepository())->createObjTree($teacherEntityDataArr);

        $courseEntity->setSubject($subjectEntity);        
        $courseEntity->setAuthor($teacherEntity);

        return $courseEntity->courseRatings();
    }

}



//service only methods - not in entity
    //search
    //view all courses
    //add 
    //edit
    //delete
    //view Single
    //view courses  by teacher               ==>view my courses (t)
    //view all the courses by subject
    // enrolled courses by stud

    // getCourseEnrollments()
    // getCourseCompletions()

    // getEnrollStudents
    // getCompleteStudents

    //viewCourseRating(Course $c)



//methods - also in entity
    //change course status


