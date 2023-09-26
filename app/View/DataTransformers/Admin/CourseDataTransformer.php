<?php

namespace App\View\DataTransformers\Admin;


use Carbon\Carbon;
use Illuminate\Support\Str;

class CourseDataTransformer{

    public static function prepareCourseListData(array $courseDataArr) : array {
        $arr = array();
        foreach ($courseDataArr as $courseData) {

            //dd($courseData);
            $tempArr     = array();

            $courseDto   = $courseData['dto'];

            $subjectDto  = $courseDto->getSubjectDto();
            $teacherDto  = $courseDto->getAuthorDto();

            $tempArr     = $courseDto->toArray();

            $tempArr['subjectId']        = $subjectDto->getId();
            $tempArr['subjectName']      = $subjectDto->getName();
            $tempArr['subjectSlug']      = $subjectDto->getSlug();

            $tempArr['teacherId']        = $teacherDto->getId();
            $tempArr['teacherName']      = $teacherDto->getFullName();
            $tempArr['teacherUserName']  = $teacherDto->getUserName();

            $tempArr['price']            = number_format( $tempArr['price'], 2, '.', '' );



            // using duration string located in database get hour, minute count
            $dur_parts                  = array_map('trim', Str::of($tempArr['duration'])->explode(':')->toArray());
            $tempArr['durationHours']   = intval(Str::of($dur_parts[0])->before('Hour')->trim()->__toString());
            $tempArr['durationMinutes'] = intval(Str::of($dur_parts[1])->before('Minute')->trim()->__toString());




            //dump($courseData['createdAt']);
            if(isset($courseData['dbRec']->created_at) || isset($courseData['createdAt'])){
                $createdAt               = $courseData['createdAt'] ?? $courseData['dbRec']->created_at;
                $tempArr['createdAt']    = $createdAt->format('Y/m/d H:i');
                $tempArr['createdAtAgo'] = $createdAt->diffForHumans();
            }

            if(isset($courseData['dbRec']->updated_at) || isset($courseData['updatedAt'])){
                $updatedAt               = $courseData['updatedAt'] ?? $courseData['dbRec']->updated_at;
                $tempArr['updatedAt']    = $updatedAt->format('Y/m/d H:i');
                $tempArr['updatedAtAgo'] = $updatedAt->diffForHumans();
            }



            $arr[] = $tempArr;
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





