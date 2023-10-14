<?php 

namespace App\View\DataFormatters\Admin;


use Carbon\Carbon;


class TeacherDataFormatter{
    
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





