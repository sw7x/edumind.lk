<?php
namespace App\Domain\Enrollments;

use App\Domain\CourseItems\FreeCourseItem as FreeCourseItemEntity;
use App\Domain\Users\StudentUser as StudentUserEntity;
//use App\Domain\Entity;
use App\Domain\AbstractEnrollment as AbstractEnrollmentEntity;

//use App\Domain\Interfaces\IEntity;
//use App\Domain\ValueObjects\DateTimeVO;
//use App\Domain\Exceptions\AttributeAlreadySetDomainException;
//use App\Domain\Course as CourseEntity;
//use App\Domain\CouponCode as CouponCodeEntity;
//use App\Domain\Users\User as UserEntity;


class FreeEnrollment extends AbstractEnrollmentEntity{

    public function __construct(FreeCourseItemEntity $courseItem, StudentUserEntity $student){
        $this->courseItem     = $courseItem;
        $this->student        = $student;
        $this->courseMessages = [];
    }


    // Getters


    // Setters


    // toArray method
    public function toArray() : array {

        return [
            'id' 			    => $this->id,
            'uuid' 			    => $this->uuid,
            'isComplete' 	    => $this->isComplete,
            'completeDate'      => $this->completeDate ? $this->completeDate->format() : null,
            'rating'            => $this->rating,

            //'courseItem'      => $this->courseItem ? $this->courseItem->toArray() : [],
            //'student'         => $this->student    ? $this->student->toArray()    : [],
            //'order'           => $this->order ? $this->order->toArray() : [],

            'courseItemArr'     => $this->courseItem->toArray(),
            'courseItemId'      => $this->courseItem->getId(),
            //'courseSelectionId' => $this->courseItem->getId(),

            'studentArr'        => $this->student->toArray(),
            'studentId'         => $this->student->getId(),

            'authorFeeArr'      => [],
            'commissionFeeArr'  => [],
            'edumindFeeArr'     => [],

            //'courseMessageArr'    => parent::ObjArrConvertToData($this->courseMessages),



        ];
    }

}
