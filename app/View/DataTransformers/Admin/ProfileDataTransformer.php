<?php 

namespace App\View\DataTransformers\Admin;



class ProfileDataTransformer{
    
    public static function prepareUserData(array $userData) : array {
        
        $userDbRec  =   $userData['dbRec'];
        $userDto    =   $userData['dto'];

        $userArr    =   array();
        $userArr    =   $userDto->toArray();

        $userArr['createdAt']    =  optional($userDbRec->created_at)->format('Y/m/d H:i');
        $userArr['createdAtAgo'] =  optional($userDbRec->created_at)->diffForHumans();
        $userArr['roleName']     =  optional($userDbRec->roles()->first())->name;
    
        return $userArr;
    }



    /*
    public static function prepareEnrolledCourseData(array $courseDtoArr) : array {
        $arr = array();
        foreach ($courseDtoArr as $courseData) {
            $tempArr    = array(); 
            $courseDto  = $courseData['dto'];
            $isComplete = $courseData['isComplete'];

            $tempArr = $courseDto->toArray();
            $tempArr['teacherName']      = $courseDto->getAuthorDto()->getFullName();
            $tempArr['teacherUserName']  = $courseDto->getAuthorDto()->getUserName();
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
    */




}



