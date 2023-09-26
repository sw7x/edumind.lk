<?php 

namespace App\View\DataTransformers\Admin;


use Carbon\Carbon;


class TeacherDataTransformer{
    
    public static function prepareMyCourseData(array $coursesDtoArr) : array {
        $arr = array();
        
        foreach ($coursesDtoArr as $coursesDto) {
            $tempArr = $coursesDto->toArray();
            $arr[]   = $tempArr;
        }
        return $arr;
    }
    


}



?>





