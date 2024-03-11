<?php

namespace App\View\DataFormatters;

class HomePageDataFormatter{

    public static function prepareCourseDataList(array $couseDtoArr) : array {
        $arr = array();
        foreach ($couseDtoArr as $courseDto) {
            $tempArr = array();

            $tempArr                = $courseDto->toArray();
            $tempArr['teacherName'] = $courseDto->getAuthorDto() ? $courseDto->getAuthorDto()->getFullName() : null;
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



