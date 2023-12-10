<?php
namespace App\Domain\Enrollments;

use App\Domain\CourseItems\PaidCourseItem as PaidCourseItemEntity;
//use App\Domain\Order as OrderEntity;

use App\Domain\AuthorFee as AuthorFeeEntity;
use App\Domain\CommissionFee as CommissionFeeEntity;
use App\Domain\EdumindFee as EdumindFeeEntity;
use App\Domain\CouponCode as CouponCodeEntity;
use App\Domain\Users\User as UserEntity;
use App\Domain\Users\StudentUser as StudentUserEntity;
use App\Domain\Factories\AuthorFeeFactory;
use App\Domain\Factories\CommissionFeeFactory;
use App\Domain\Factories\EdumindFeeFactory;
use App\Domain\ValueObjects\DateTimeVO;
use App\Domain\AbstractEnrollment as AbstractEnrollmentEntity;

//use App\Domain\Interfaces\IEntity;
//use App\Domain\Entity;

class PaidEnrollment extends AbstractEnrollmentEntity{

    /* associations */
    private AuthorFeeEntity      $authorFee;
    private CommissionFeeEntity  $commissionFee;
    private EdumindFeeEntity     $edumindFee;
    //private OrderEntity        $order;


    public function __construct(PaidCourseItemEntity $courseItem, StudentUserEntity $student){
        $this->courseItem     = $courseItem;
        // $this->order       = $order;
        $this->student        = $student;

        //$this->authorFee     = new AuthorFee($courseItem->getAuthorAmount());
        //$this->commissionFee = new CommissionFee($courseItem->getBeneficiaryEarnAmount());
        //$this->edumindFee    = new EdumindFee($courseItem->edumindNetAmount());

        $this->authorFee      = (new AuthorFeeFactory())->createObj([
            'amount' => $courseItem->getAuthorAmount()->getValue()
        ]);

        $this->commissionFee  = (new CommissionFeeFactory())->createObj([
            'amount' => $courseItem->getBeneficiaryEarnAmount()->getValue()
        ]);

        $edumindFee           = (new EdumindFeeFactory())->createObj([
            'amount' => $courseItem->edumindNetAmount()->getValue()
        ]);
        $edumindFee->setDate(new DateTimeVO(now()));
        $this->edumindFee     = $edumindFee;

        $this->courseMessages = [];
    }



    // Getters
    public function getAuthorFee() : AuthorFeeEntity {
        return $this->authorFee;
    }

    public function getCommissionFee() : CommissionFeeEntity {
        return $this->commissionFee;
    }

    public function getEdumindFee() : EdumindFeeEntity {
        return $this->edumindFee;
    }

    /*
    public function getOrder()
    {
        return $this->order;
    }
    */



    // Setters
    /*
    public function setOrder(&$order){
        //dump($order);
        $this->order = $order;
    }
    */



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


            'authorFeeArr'      => $this->authorFee->toArray(),
            'commissionFeeArr'  => $this->commissionFee->toArray(),
            'edumindFeeArr'     => $this->edumindFee->toArray(),

            //'courseMessagesArr'    => parent::ObjArrConvertToData($this->courseMessages),
        ];
    }


    public function checkGivenCouponUsed(CouponCodeEntity $cc) : bool {
        return $this->courseItem->checkGivenCouponUsed($cc);
    }


    public function beneficiary() : ?UserEntity {
        $courseItem         = $this->getCourseItem();
        $courseItemCoupon   = $courseItem->getCouponCode();

        if(!$courseItemCoupon) return null;
        return $courseItemCoupon->getBeneficiary();
    }

    public function usedCoupon() : ?CouponCodeEntity {
        $courseItem         = $this->getCourseItem();
        return $courseItem->getCouponCode();
    }

}