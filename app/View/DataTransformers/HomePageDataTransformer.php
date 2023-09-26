<?php 

namespace App\View\DataTransformers;

class HomePageDataTransformer{
    
    public static function prepareCourseDataList(array $couseDtoArr) : array {
        $arr = array();
        foreach ($couseDtoArr as $courseDto) {
            $tempArr = array();
            
            $tempArr                = $courseDto->toArray();
            $tempArr['teacherName'] = $courseDto->getAuthorDto()->getFullName();
            $arr[]                  = $tempArr;
        }
        return $arr;
    }


    public static function prepareTeacherDataList(array $userDtoArr) : array {
        $arr = array();
        foreach ($userDtoArr as $userDto) {
            $arr[] = $userDto->toArray();
        }
        return $arr;
    }


}



