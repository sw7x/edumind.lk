<?php 

namespace App\View\DataFormatters;



class CourseDataFormatter{
    
    public static function prepareCourseData(array $courseData) : array {
        $tempArr        = array();

        $courseDto      = $courseData['dto'];  
        $courseDbRec    = $courseData['dbRec'];  

        $tempArr        = $courseDto->toArray();

        $createdAt               = $courseDbRec->created_at;
        $tempArr['createdAt']    = $createdAt->format('Y/m/d H:i');
        $tempArr['createdAtAgo'] = $createdAt->diffForHumans();
        
        return $tempArr;
    }


    public static function prepareCoursListData(array $courseDataArr) : array {
        $arr = array();
        foreach ($courseDataArr as $courseData) {
            $tempArr     = array();
            $courseDto   = $courseData['dto'];
            $courseDbRec = $courseData['dbRec'];
            $teacherDto  = $courseDto->getAuthorDto();

            $tempArr     = $courseDto->toArray();
                    
            $tempArr['teacher']           = $teacherDto;
            $tempArr['teacherUsername']  = optional($teacherDto)->getUsername();
            $tempArr['teacherFullName']  = optional($teacherDto)->getFullName();            
            $tempArr['enrollmentsStatus'] = $courseData['enrollments_status'] ?? null;

            $arr[]  = $tempArr;
        }

        return $arr;
    }
    







}



