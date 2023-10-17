<?php

namespace App\Common\SharedServices;


use App\Mappers\CourseMapper;
use App\Domain\Course as CourseEntity;
use App\DataTransferObjects\CourseDto;
use App\Domain\Factories\CourseFactory;
use Illuminate\Support\Arr;


class CourseSharedService
{

    //validate course content format
    public function validateCourseContent($courseContent) : array {
        $isEmptyContent = is_null($courseContent) || $courseContent === [] || $courseContent === '';
        $isAssocArr     = (is_array($courseContent) && Arr::isAssoc($courseContent));

        $valid          =   $isEmptyContent ? true : $isAssocArr;        
        $content        =   $isAssocArr ? $courseContent : [];
        
        return array('data' => $content, 'isInvFormat' => !$valid);
    }

}
