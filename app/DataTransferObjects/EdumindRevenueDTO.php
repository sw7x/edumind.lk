<?php

namespace App\DataTransferObjects;


use App\DataTransferObjects\AbstractDto;
use Illuminate\Http\Request;



class EdumindRevenueDTO extends AbstractDto{
    
    public $id;
    public $edumindEarnAmount;
    public $invoiceId;
    public $enrolledDateTime;
    public $couponCode;
    public $discountPercentage;
    public $course;
    public $teacher;
    public $coursePrice;
    public $student;
    public $edumindShareFromCoursePrice;
    public $edumindEarnAmountFromCoursePrice;
    public $discountAmount;
    public $beneficiaryShareFromDiscount;
    public $edumindShareFromDiscount;
    public $beneficiaryEarnAmount;
    public $edumindLoseAmount;
    
    public function __construct(
        $id,
        $edumindEarnAmount,
        $invoiceId,
        $enrolledDateTime,
        $couponCode,
        $discountPercentage,
        $course,
        $teacher,
        $coursePrice,
        $student,
        $edumindShareFromCoursePrice,
        $edumindEarnAmountFromCoursePrice,
        $discountAmount,
        $beneficiaryShareFromDiscount,
        $edumindShareFromDiscount,
        $beneficiaryEarnAmount,
        $edumindLoseAmount
    ) {
        $this->id                                = $id;
        $this->edumindEarnAmount                 = $edumindEarnAmount;
        $this->invoiceId                         = $invoiceId;
        $this->enrolledDateTime                  = $enrolledDateTime;
        $this->couponCode                        = $couponCode;
        $this->discountPercentage                = $discountPercentage;
        $this->course                            = $course;
        $this->teacher                           = $teacher;
        $this->coursePrice                       = $coursePrice;
        $this->student                           = $student;
        $this->edumindShareFromCoursePrice       = $edumindShareFromCoursePrice;
        $this->edumindEarnAmountFromCoursePrice  = $edumindEarnAmountFromCoursePrice;
        $this->discountAmount                    = $discountAmount;
        $this->beneficiaryShareFromDiscount      = $beneficiaryShareFromDiscount;
        $this->edumindShareFromDiscount          = $edumindShareFromDiscount;
        $this->beneficiaryEarnAmount             = $beneficiaryEarnAmount;
        $this->edumindLoseAmount                 = $edumindLoseAmount;
    }

    
    // Transformation method
    public function toArray(): array{
        return [
            'id'                                 => $this->id,
            'edumindEarnAmount'                  => $this->edumindEarnAmount,
            'invoiceId'                          => $this->invoiceId,
            'enrolledDateTime'                   => $this->enrolledDateTime,
            'couponCode'                         => $this->couponCode,
            'discountPercentage'                 => $this->discountPercentage,
            'course'                             => $this->course,
            'teacher'                            => $this->teacher,
            'coursePrice'                        => $this->coursePrice,
            'student'                            => $this->student,
            'edumindShareFromCoursePrice'        => $this->edumindShareFromCoursePrice,
            'edumindEarnAmountFromCoursePrice'   => $this->edumindEarnAmountFromCoursePrice,
            'discountAmount'                     => $this->discountAmount,
            'beneficiaryShareFromDiscount'       => $this->beneficiaryShareFromDiscount,
            'edumindShareFromDiscount'           => $this->edumindShareFromDiscount,
            'beneficiaryEarnAmount'              => $this->beneficiaryEarnAmount,
            'edumindLoseAmount'                  => $this->edumindLoseAmount,
        ];
    }
        

    
    // Serialization method (JSON example)
    /* public function toJson(){
        return json_encode($this->toArray());
    } */

}
