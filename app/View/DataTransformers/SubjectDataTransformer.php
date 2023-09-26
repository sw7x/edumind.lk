<?php 

namespace App\View\DataTransformers;

class SubjectDataTransformer{
    
    public static function prepareSubjectDataList(array $subjectDtoArr) : array {
        $arr = array();
        foreach ($subjectDtoArr as $subjectDto) {
            $arr[] = $subjectDto->toArray();
        }
        return $arr;
    }


    public static function prepareViewSubjectData(array $subjectDataArr) : array {
        $coursesArr = array();
        foreach ($subjectDataArr['coursesDtoArr'] as $coursesDto) {
            $coursesArr[] = $coursesDto->toArray();
        }
        
        $arr = array();
        $arr['subject']         = ($subjectDataArr['subjectDto'])->toArray();
        $arr['subjectCourses']  = $coursesArr;
        $arr['bgColor']         = $subjectDataArr['bgColor'];
        $arr['txtColor']        = $subjectDataArr['txtColor']; 
        return $arr;
    }

    




}



/*


edumind_lose_amount
'edumindLoseAmount'             => number_format((float)$courseItemDto->getEdumindLooseAmount(), 2, '.', ''),

discount_amount
'discountAmount'                => number_format((float)$courseItemDto->getDiscountAmount(), 2, '.', ''), 

beneficiary_earn_amount
'beneficiaryEarnAmount'         => number_format((float)$commissionFeeDto->getAmount(), 2, '.', ''), ///////////

edumind_amount
'edumindEarnAmount'                 => number_format((float)$edumindFeeDto->getAmount(), 2, '.', ''),


ok - 'edumindEarnAmountFromCoursePrice'  => number_format((float)$courseItemDto->getEdumindAmount(), 2, '.', ''), 



*/