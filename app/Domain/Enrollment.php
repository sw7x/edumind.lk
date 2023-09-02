<?php
namespace App\Domain;

use App\Domain\CourseItem as CourseItemEntity;
use App\Domain\Order;
use App\Domain\Users\StudentUser as StudentUserEntity;

use App\Domain\AuthorFee as AuthorFeeEntity;
use App\Domain\CommissionFee as CommissionFeeEntity;
use App\Domain\EdumindFee as EdumindFeeEntity;
use App\Domain\Course as CourseEntity;
use App\Domain\CouponCode as CouponCodeEntity;
use App\Domain\Users\User as UserEntity;





use App\Domain\Factories\AuthorFeeFactory;
use App\Domain\Factories\CommissionFeeFactory;
use App\Domain\Factories\EdumindFeeFactory;
use App\Domain\Interfaces\IEntity;
use App\Domain\Entity;

use App\Domain\ValueObjects\DateTimeVO;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;



class Enrollment extends Entity{

    private ?int        $id             = null;
    private ?string     $uuid           = null;
    private ?bool       $isComplete     = null;
    private ?DateTimeVO $completeDate   = null;
    private ?int        $rating         = null;

    
    /* compositions */
    private CourseItemEntity     $courseItem;
    private StudentUserEntity    $student;

    /* associations */
    private AuthorFeeEntity      $authorFee;
    private CommissionFeeEntity  $commissionFee;
    private EdumindFeeEntity     $edumindFee;
    //private OrderEntity        $order;
    
    /* @var CourseMessageEntity[] */
    private array                $courseMessages;






    public function __construct(CourseItemEntity $courseItem, StudentUserEntity $student){
        $this->courseItem     = $courseItem;
        // $this->order       = $order;
        $this->student        = $student;

        //$this->authorFee     = new AuthorFee($courseItem->getAuthorAmount());
        //$this->commissionFee = new CommissionFee($courseItem->getBeneficiaryEarnAmount());
        //$this->edumindFee    = new EdumindFee($courseItem->edumindEarnTotalAmount());
            
        $this->authorFee      = (new AuthorFeeFactory())->createObj([
            'amount' => $courseItem->getAuthorAmount()->getValue()
        ]);

        $this->commissionFee  = (new CommissionFeeFactory())->createObj([
            'amount' => $courseItem->getBeneficiaryEarnAmount()->getValue()
        ]);

        $edumindFee           = (new EdumindFeeFactory())->createObj([
            'amount' => $courseItem->edumindEarnTotalAmount()->getValue()
        ]);
        $edumindFee->setDate(new DateTimeVO(now()));
        $this->edumindFee     = $edumindFee;
        
        $this->courseMessages = [];
    }





    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getIsComplete() : ?bool {
        return $this->isComplete;
    }

    public function getCompleteDate() : ?DateTimeVO {
        return $this->completeDate;
    }

    public function getRating() : ?int {
        return $this->rating;
    }

    public function getCourseItem() : CourseItemEntity {
        return $this->courseItem;
    }

    public function getStudent() : StudentUserEntity {
        return $this->student;
    }

    public function getAuthorFee() : AuthorFeeEntity {
        return $this->authorFee;
    }

    public function getCommissionFee() : CommissionFeeEntity {
        return $this->commissionFee;
    }

    public function getEdumindFee() : EdumindFeeEntity {
        return $this->edumindFee;
    }

    public function getCourseMessages() : array {
        return $this->courseMessages;
    }

    /*     
    public function getOrder()
    {
        return $this->order;
    }
    */




    // Setters
    final public function setId(int $id) : void {
        if ($this->id !== null) {
            throw new AttributeAlreadySetDomainException('id attribute already been set and cannot be changed.');
        }
        $this->id  = $id;
    }
        
    final public function setUuid(string $uuid) : void {
        if ($this->uuid !== null) {
            throw new AttributeAlreadySetDomainException('uuid attribute has already been set and cannot be changed.');
        }
        $this->uuid = $uuid;
    }

    public function setIsComplete(bool $isComplete) : void {
        $this->isComplete = $isComplete;
    }

    public function setCompleteDate(DateTimeVO $completeDate) : void {
        $this->completeDate = $completeDate;
    }

    public function setRating(int $rating) : void {
        $this->rating = $rating;
    }
    
    final public function setCourseMessages(array $courseMessages) : void {
        if ($this->courseMessages !== []) {
            throw new AttributeAlreadySetDomainException('courseMessages attribute already been set and cannot be changed.');
        }
        $this->courseMessages = $courseMessages;
    }
    
    /* 
    public function setOrder(&$order){
        //dump($order);
        $this->order = $order;
    }
    */



    




    // toArray method
    public function toArray() : array {
        
        /*$courseMessageArr = [];
        foreach ($this->courseMessages as $courseMessage) {
            $courseMessageArr[] = $courseMessage->toArray();
        }*/

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

    public function course() : CourseEntity {
        $courseItem         = $this->getCourseItem();
        return $courseItem->getCourse();
    }


    public function usedCoupon() : ?CouponCodeEntity {
        $courseItem         = $this->getCourseItem();
        return $courseItem->getCouponCode();
    }


}