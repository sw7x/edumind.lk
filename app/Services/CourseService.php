<?php


namespace App\Services;




use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\Role;

class CourseService
{

    public function loadNewCourse(){

        return Course::latest()->take(8)->get();
        //return Course::latest('id')->take(8)->get();

    }


    public function loadPopularCourse(){




        /*
        // todo filter when rows have (course_id,student_id) duplicate values
        return Course::whereHas('students', function ($q) {
            $q->where('enrollments.status', 'enrolled')
                ->orWhere('enrollments.status', 'completed');
        })->withCount(['students'=> function($query){
            $query->where('enrollments.status', 'enrolled')
                ->orWhere('enrollments.status', 'completed');
        }])->orderBy('students_count', 'desc')->skip(0)->take(8)->get();
        //dd($rr);
        */



        return Course::orderBy('id', 'desc')->skip(0)->take(5)->get();









    }



 /*
    public function checkUsernameExists($username){
        return User::where('username',$username)->get()->count();
    }

   public function getlinkCount($data){
        return User::where('username',$username)->get()->count();
    }*/

    public function getCourseValidationErrors($validationErrorsArr){

        $contentLinksErrMsgArr    = array();
        $contentErrMsgArr         = array();
        $infoErrMsgArr            = array();

        //dd($validationErrorsArr);
        
        foreach ($validationErrorsArr as $errField => $valErrMsgArr){            
            if(Str::startsWith($errField, 'contentArr.')){                
                
                $sectionHeading = Str::of($errField)->explode('.')[1];             
                foreach ($valErrMsgArr as $errMsg){
                    if(isset(Str::of($errField)->explode('.')[2])){
                        $linkIndex = Str::of($errField)->explode('.')[2];

                        if(!isset($contentLinksErrMsgArr[$sectionHeading][$linkIndex])){
                            $contentLinksErrMsgArr[$sectionHeading][$linkIndex] = $errMsg;
                        }else{
                            $contentLinksErrMsgArr[$sectionHeading][$linkIndex] .= ', '.$errMsg;
                        }
                    
                    }else{
                        $contentErrMsgArr[$sectionHeading][] = $errMsg;
                    }                    
                }
            }else{
                $infoErrMsgArr[$errField] = $valErrMsgArr;               
            }
        }
        
        return array(
            'contentLinksErrMsgArr' => $contentLinksErrMsgArr, 
            'contentErrMsgArr'      => $contentErrMsgArr,
            'infoErrMsgArr'         => $infoErrMsgArr
        );
    }




    //enrollToFreeCourse(Course)
   
    //search


    //view all courses
    //add 
    //edit
    //delete
    //view Single
    //change course status


    



    //view courses  by teacher               ==>view my courses (t)
    


    //view all the courses by subject


    // enrolled courses by stud



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
        $course         = Course::find($courseDto->id);
        $courseEntity   = (new CourseRepository())->hydrateCourseData($course);

        $subject         = Subject::find($courseDto->subjectId);
        $subjectEntity   = (new SubjectRepository())->hydrateSubjectData($subject);

        $teacher        = User::find($courseDto->teacherId);
        $teacherEntity  = (new UserRepository())->hydrateUserData($teacher);

        $courseEntity->setSubject($subjectEntity);        
        $courseEntity->setAuthor($teacherEntity);

        return $courseEntity->courseRatings();
    }

}