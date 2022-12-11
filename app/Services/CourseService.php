<?php


namespace App\Services;




use App\Models\Course;
use Illuminate\Support\Str;


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


        foreach ($validationErrorsArr as $errField => $valErrMsgArr){
            //dump($errField);
            //dump($valErrMsgArr);
            if(Str::startsWith($errField, 'contentArr.')){
                $sectionHeading = Str::of($errField)->explode('.')[1];             
                
                //dump($sectionHeading);
                //dump($valErrMsgArr);
                foreach ($valErrMsgArr as $errMsg){

                    if(isset(Str::of($errField)->explode('.')[2])){
                        $linkIndex = Str::of($errField)->explode('.')[2];
                        
                        //dump($contentLinksErrMsgArr);
                        //dump("contentLinksErrMsgArr-{$sectionHeading}-{$linkIndex}");
                        //dump(isset($contentLinksErrMsgArr[$sectionHeading][$linkIndex]));                         

                        if(!isset($contentLinksErrMsgArr[$sectionHeading][$linkIndex])){
                            $contentLinksErrMsgArr[$sectionHeading][$linkIndex] = $errMsg;
                        }else{
                            $contentLinksErrMsgArr[$sectionHeading][$linkIndex] .= ', '.$errMsg;
                        }

                        //dump($contentLinksErrMsgArr[$sectionHeading][$linkIndex]);
                        //dump($contentLinksErrMsgArr);
                        //dump("=====================");                        
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







}
