<?php 

namespace App\View\DataTransformers;




class StudentDataTransformer{
    
    public static function prepareUserData(array   $loggedInUserData) : array {
        $loggedInUserDto = $loggedInUserData['dto'];  
        $createdAt       = $loggedInUserData['createdAt'];  

        $tempArr                 = $loggedInUserDto->toArray();
        $tempArr['createdAt']    = $createdAt->format('Y/m/d H:i');
        $tempArr['createdAtAgo'] = $createdAt->diffForHumans();
        return $tempArr;
    }



    public static function prepareEnrolledCourseData(array $courseDtoArr) : array {
        $arr = array();
        foreach ($courseDtoArr as $courseData) {
            $tempArr    = array(); 
            $courseDto  = $courseData['dto'];
            $isComplete = $courseData['isComplete'];

            $tempArr = $courseDto->toArray();
            $tempArr['teacherName']      = optional($courseDto->getAuthorDto())->getFullName();
            $tempArr['teacherUserName']  = optional($courseDto->getAuthorDto())->getUserName();
            $tempArr['price']            = number_format( $tempArr['price'], 2, '.', '' );
            $tempArr['isComplete']       = $isComplete;

            $arr[] = $tempArr;
        }
        return $arr;
    }



    public static function prepareCourseData(array $courseDtoArr) : array {
        $arr = array();
        foreach ($courseDtoArr as $courseDto) {
            $tempArr = array();            
            $tempArr = $courseDto->toArray();

            $tempArr['teacherName']      = $courseDto->getAuthorDto()->getFullName();
            $tempArr['teacherUserName']  = $courseDto->getAuthorDto()->getUserName();
            $tempArr['price']            = number_format( $tempArr['price'], 2, '.', '' );

            $arr[] = $tempArr;
        }
        return $arr;
    }




}



