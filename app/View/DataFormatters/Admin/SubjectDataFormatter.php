<?php 

namespace App\View\DataFormatters\Admin;
use App\DataTransferObjects\SubjectDto;

class SubjectDataFormatter{
    
    public static function prepareSubjectDataList(array $subjectDataArr) : array {
        $arr = array();
        foreach ($subjectDataArr as $subjectItem) {
            $tempArr            = array();
            
            $subjectDto         = $subjectItem['data'];
            
            $tempArr['data']    = $subjectDto->toArray();
            $tempArr['dbRec']   = $subjectItem['dbRec'];
            $arr[]              = $tempArr;
        }
        return $arr;
    }


    public static function prepareViewSubjectData(SubjectDto $subjectDto) : array {        
        return $subjectDto->toArray();        
    }

    




}



