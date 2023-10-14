<?php 

namespace App\View\DataFormatters;




class TeacherDataFormatter{
    
    public static function prepareUserData(array $userData) : array {
        $userDto    = $userData['dto'];  
        $createdAt  = $userData['createdAt'];  

        $tempArr                 = $userDto->toArray();
        $tempArr['createdAt']    = $createdAt->format('Y/m/d H:i');
        $tempArr['createdAtAgo'] = $createdAt->diffForHumans();
        return $tempArr;
    }



    public static function prepareUserListData(array $userDataArr) : array {
        $arr = array();
        foreach ($userDataArr as $userData) {
            $userDto    = $userData['dto'];
            $tempArr     = array();

            $tempArr                   = $userDto->toArray();
            $tempArr['courseCount']    = $userData['courseCount'];
            //$tempArr['createdAt']    = $createdAt->format('Y/m/d H:i');
            //$tempArr['createdAtAgo'] = $createdAt->diffForHumans();
            $arr[] = $tempArr;
        }

        return $arr;
    }



    
    public static function prepareCourseData(array $courseDtoArr) : array {
        $arr = array();
        foreach ($courseDtoArr as $courseDto) {
            $subjectDto  = $courseDto->getsubjectDto();            
            $tempArr     = array();

            $tempArr     = $courseDto->toArray();

            $tempArr['subjectName']      = $subjectDto->getName();
            $tempArr['subjectSlug']      = $subjectDto->getSlug();
            //$tempArr['teacherName']      = $courseDto->getAuthorDto()->getFullName();
            //$tempArr['teacherUserName']  = $courseDto->getAuthorDto()->getUserName();


            $tempArr['price']       = number_format( $tempArr['price'], 2, '.', '' );

            $arr[] = $tempArr;
        }
        return $arr;
    }













    public static function __prepareCourseData(array $courseDtoArr) : array {
        $arr = array();
        foreach ($courseDtoArr as $courseDto) {
            $tempArr     = array(); 
            $tempArr     = $courseDto->toArray();

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








}



