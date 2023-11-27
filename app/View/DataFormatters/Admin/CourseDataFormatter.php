<?php

namespace App\View\DataFormatters\Admin;


use Carbon\Carbon;
use Illuminate\Support\Str;


class CourseDataFormatter{

    public static function prepareCourseListData(array $courseDataArr) : array {
        $arr = array();
        foreach ($courseDataArr as $courseData) {

            //dd($courseData);
            $tempArr     = array();

            $courseDto   = $courseData['dto'];

            $subjectDto  = $courseDto->getSubjectDto();
            $teacherDto  = $courseDto->getAuthorDto();

            $tempArr['data']     = $courseDto->toArray();

            $tempArr['data']['subjectId']        = $subjectDto->getId();
            $tempArr['data']['subjectName']      = $subjectDto->getName();
            $tempArr['data']['subjectSlug']      = $subjectDto->getSlug();

            $tempArr['data']['teacherId']        = $teacherDto->getId();
            $tempArr['data']['teacherName']      = $teacherDto->getFullName();
            $tempArr['data']['teacherUserName']  = $teacherDto->getUserName();

            $tempArr['data']['price']            = number_format( $tempArr['data']['price'], 2, '.', '' );



            // using duration string located in database get hour, minute count
            $dur_parts                  = array_map('trim', Str::of($tempArr['data']['duration'])->explode(':')->toArray());
            $tempArr['data']['durationHours']   = intval(Str::of($dur_parts[0])->before('Hour')->trim()->__toString());
            $tempArr['data']['durationMinutes'] = intval(Str::of($dur_parts[1])->before('Minute')->trim()->__toString());

            if(isset($courseData['dbRec'])){
                $tempArr['dbRec'] = $courseData['dbRec'];
            }


            //dump($courseData['createdAt']);
            if(isset($courseData['dbRec']->created_at)){
                $createdAt                          = $courseData['dbRec']->created_at;
                $tempArr['data']['createdAt']       = $createdAt->format('Y/m/d H:i');
                $tempArr['data']['createdAtAgo']    = $createdAt->diffForHumans();
            }

            if(isset($courseData['dbRec']->updated_at)){
                $updatedAt               = $courseData['dbRec']->updated_at;
                $tempArr['data']['updatedAt']    = $updatedAt->format('Y/m/d H:i');
                $tempArr['data']['updatedAtAgo'] = $updatedAt->diffForHumans();
            }

        
            $arr[]  =   $tempArr;
        }
        return $arr;
    }







    public static function __prepareCourseListData(array $courseDataArr) : array {
        $arr = array();
        foreach ($courseDataArr as $courseData) {
            $tempArr     = array();

            $courseDto   = $courseData['dto'];
            $subjectDto  = $courseDto->getSubjectDto();
            $teacherDto  = $courseDto->getAuthorDto();

            $tempArr     = $courseDto->toArray();

            $tempArr['subjectName']      = $subjectDto->getName();
            $tempArr['subjectSlug']      = $subjectDto->getSlug();
            $tempArr['teacherName']      = $teacherDto->getFullName();
            $tempArr['teacherUserName']  = $teacherDto->getUserName();
            $tempArr['price']            = number_format( $tempArr['price'], 2, '.', '' );

            if(isset($courseData['dbRec']->created_at) || isset($courseData['createdAt'])){
                $createdAt               = $courseData['createdAt'] ?? $courseData['dbRec']->created_at;
                $tempArr['createdAt']    = $createdAt;
                $tempArr['createdAtAgo'] = $createdAt->diffForHumans();
            }

            if(isset($courseData['dbRec']->updated_at) || isset($courseData['updatedAt'])){
                $updatedAt               = $courseData['updatedAt'] ?? $courseData['dbRec']->updated_at;
                $tempArr['updatedAt']    = $updatedAt;
                $tempArr['updatedAtAgo'] = $updatedAt->diffForHumans();
            }



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
            $tempArr['teacherName']      = $courseDto->getAuthorDto()->getFullName();
            $tempArr['teacherUserName']  = $courseDto->getAuthorDto()->getUserName();
            $tempArr['price']            = number_format( $tempArr['price'], 2, '.', '' );
            $arr[] = $tempArr;
        }
        return $arr;
    }

    public static function prepareUserListData(array $userDtoArr) : array {
        $arr = array();

        foreach ($userDtoArr as $userDto) {
            $tempArr    = $userDto->toArray();
            $arr[]      = $tempArr;
        }
        return $arr;
    }

    public static function prepareSubjectListData(array $subjectDataArr) : array {
        $arr = array();

        foreach ($subjectDataArr as $subjectData) {
            $subjectDto = $subjectData['data'];
            $tempArr    = $subjectDto->toArray();
            $arr[]      = $tempArr;
        }
        return $arr;
    }










    public static function prepareUserData(array $userDataArr) : array {
        //dd($userDto);
        $userDto         = $userDataArr['dto'];
        $arr             = $userDto->toArray();
        $arr['userType'] = $userDto->getRoleDto() ? $userDto->getRoleDto()->getName() : null;

        $arr['lastLogin']       = $userDataArr['dbRec']->last_login;
        $arr['lastLoginTime']   = $userDataArr['dbRec']->getLastLoginTime();
        return $arr;
    }

    public static function prepareUnApprovedTeachers(array $teachersArr) : array {
        $arr = array();

        foreach ($teachersArr as $teacherUserDtoArr) {
            $tempArr= $teacherUserDtoArr->toArray();
            $arr[]  = $tempArr;
        }
        return $arr;
    }

}



?>





