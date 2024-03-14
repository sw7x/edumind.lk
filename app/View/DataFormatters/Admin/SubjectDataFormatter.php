<?php 

namespace App\View\DataFormatters\Admin;
use App\DataTransferObjects\SubjectDto;

class SubjectDataFormatter{
    
    public static function prepareSubjectDataList(array $subjectDataArr) : array {
        $arr = array();
        foreach ($subjectDataArr as $subjectItem) {
            $tempArr           = array();
            
            $subjectDto        = $subjectItem['data'];
            
            $tempArr['data']   = $subjectDto->toArray();
            $tempArr['dbRec']  = $subjectItem['dbRec'];            
            
            $tempArr['data']['course_count'] = $subjectItem['dbRec']->courses->count();     

            $arr[] = $tempArr;
        }
        return $arr;
    }


    public static function prepareViewSubjectData(array $subjectData) : array {        
        $arr = $subjectData['dto']->toArray();
        $arr['isDelete'] = $subjectData['dbRec']->trashed();        
        return $arr;        
    }

    




}



