<?php

namespace App\SharedServices;


use App\Mappers\CourseMapper;
use App\Domain\Course as CourseEntity;
use App\DataTransferObjects\CourseDto;
use App\Domain\Factories\CourseFactory;
use Illuminate\Support\Arr;


class CourseSharedService
{

    //validate course content format
    public function validateCourseContent($courseContent) : array {
        $valid  =   (is_null($courseContent) || $courseContent === [] || $courseContent === '') ?
                        true :
                        (is_array($courseContent) && Arr::isAssoc($courseContent));        

        $content    =   (is_array($courseContent) && Arr::isAssoc($courseContent)) ? $courseContent : [];

        return array('data' => $content, 'isInvFormat' => !$valid);
    }

}
