<?php 

namespace App\View\DataTransformers\Admin;

class EdumindRevenueDataTransformer{
    
    public static function prepareData(array $dataArr) : array {
        //dump2($dataArr);
        
        $earningsData = array();
        foreach ($dataArr as $dataItem) {
            
            $invoiceDto         = $dataItem['invoiceDto'];
            $enrollmentDto      = $dataItem['enrollmentDto'];

            
            $edumindFeeDto      = $enrollmentDto->getEdumindFeeDto();
            $commissionFeeDto   = $enrollmentDto->getCommissionFeeDto();
            $courseItemDto      = $enrollmentDto->getCourseItemDto();
            $couponCodeDto      = $courseItemDto->getCouponCodeDto();
            $courseDto          = $courseItemDto->getCourseDto();
            
            $earningsData[]     =  array(
                'id'                            => $enrollmentDto->getId(),
                'invoiceId'                     => $invoiceDto->getId(),
                'enrolledDateTime'              => $invoiceDto->getCheckoutDate(),

                'coursePrice'                   => number_format((float)$courseDto->getPrice(), 2, '.', ''),   
                'course'                        => $courseDto->getName(),
                'teacher'                       => $courseDto->getAuthorDto()->getFullName(),
                
                'edumindLoseAmount'             => number_format((float)$courseItemDto->getEdumindLooseAmount(), 2, '.', ''),
                'discountAmount'                => number_format((float)$courseItemDto->getDiscountAmount(), 2, '.', ''), 
                'beneficiaryEarnAmount'         => number_format((float)$commissionFeeDto->getAmount(), 2, '.', ''), ///////////

                'discountPercentage'            => (isset($couponCodeDto))? $couponCodeDto->getDiscountPercentage() : null,
                'student'                       => $enrollmentDto->getStudentDto()->getFullName(),
                'couponCode'                    => (isset($couponCodeDto))? $couponCodeDto->getCode() : '',
                
                'edumindShareFromCoursePrice'   => $courseDto->getEdumindSharePercentage(),
                
                'beneficiaryShareFromDiscount'  => (isset($couponCodeDto))? $couponCodeDto->getCommisionPercentageFromDiscount() : null,
                'edumindShareFromDiscount'      => (isset($couponCodeDto))? $couponCodeDto->getEdumindPercentageFromDiscount() : null,

                'edumindEarnAmount'                 => number_format((float)$edumindFeeDto->getAmount(), 2, '.', ''),
                'edumindEarnAmountFromCoursePrice'  => number_format((float)$courseItemDto->getEdumindAmount(), 2, '.', ''), 
            );

        }
        
        //dd($earningsData);
        return $earningsData;
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