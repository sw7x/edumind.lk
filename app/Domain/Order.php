<?php

namespace App\Domain;
use App\Domain\Factories\InvoiceFactory;
use App\Domain\Users\StudentUser as StudentUserEntity;
use App\Domain\Entity;
use App\Domain\Invoice as InvoiceEntity;

use App\Domain\CourseItems\PaidCourseItem as PaidCourseItemEntity;
use App\Domain\CourseEntity as CourseEntity;
use App\Domain\Users\TeacherUser as TeacherUserEntity;
use App\Domain\Enrollments\PaidEnrollment as PaidEnrollmentEntity;

use App\Domain\ValueObjects\PercentageVO;
use App\Domain\ValueObjects\AmountVO;
use App\Domain\ValueObjects\DateTimeVO;

use App\Domain\Exceptions\AttributeAlreadySetDomainException;
use App\Domain\Exceptions\DomainException;

class Order extends Entity{
	
    private ?int               $id           = null;
    private ?string            $uuid         = null;
	private ?DateTimeVO        $checkOutDate = null;
    
    
    /* associations */
    private ?InvoiceEntity    $invoice       = null;
    private StudentUserEntity $customer;
    
    /* @var PaidEnrollmentEntity[] */
    private array             $enrollments   = [];




    /* @var enrollments => PaidEnrollmentEntity[] */
    public function __construct(array $enrollments, StudentUserEntity $customer){        
        if(empty($enrollments))
            throw new DomainException("At least one paid enrollment is required to create an order.");
            
        foreach ($enrollments as $enrollment) {            
            //$enrollment->setOrder($this);
            $this->enrollments[] = $enrollment;
        }
        $this->customer = $customer;
    }

    






    
    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }   

    public function getCheckOutDate() : ?DateTimeVO {
        return $this->checkOutDate;
    }
    
    public function getInvoice() : ?InvoiceEntity {
        return $this->invoice;
    }    

    public function getCustomer() : StudentUserEntity {
        return $this->customer;
    }
    
    public function getAllEnrollements() : array {
        return $this->enrollments;
    }







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

    public function setCheckOutDate(DateTimeVO $checkOutDate) : void {
        $this->checkOutDate = $checkOutDate;
    }
    
    
    /**
    * @param PaidEnrollmentEntity[] $enrollments
    * @return void
    
    final public function setEnrollments(array $enrollments) : void {
        if ($this->enrollments !== []) {
            throw new AttributeAlreadySetDomainException('enrollments attribute already been set and cannot be changed.');
        }
        $this->enrollments = $enrollments;
    }
    */
    




    // toArray method
    public function toArray() : array {
        
        /*
        $enrollmentArr = [];
        foreach ($this->enrollments as $enrollment) {
            $enrollmentArr[] = $enrollment->toArray();
        }
        */

        return [            
            'id'             => $this->id,
            'uuid'           => $this->uuid,
            'checkoutDate'   => $this->checkOutDate ? $this->checkOutDate->format() : null,
            
            'invoiceArr'     => $this->invoice ? $this->invoice->toArray() : null,
            'invoiceId'      => $this->invoice ? $this->invoice->getId()   : null,

            //'enrollments'  => $this->enrollments ? $this->enrollments->toArray() : null,
            'enrollmentsArr' => parent::ObjArrConvertToData($this->enrollments),
            
            'studentArr'     => $this->customer->toArray(),
            'studentId'      => $this->customer->getId(),
        ];
    }
    
    
    



    /* ===== methods =========*/
    public function createInvoice(array $invoiceArr) : void {       
        //$invoiceEntity = (new InvoiceFactory())->createObjTree($invoiceArr); 
        $invoiceEntity = (new InvoiceFactory())->createObj($invoiceArr); 
        $this->invoice = $invoiceEntity;
    }

    public function invoiceNumber() : int {
        return $this->invoice->getId();
    }

    public function addEnrollment(PaidCourseItemEntity $courseItem, StudentUserEntity $student) : void {        
        $enrollment          = new PaidEnrollmentEntity($courseItem, $student);
        //$enrollment.setOrder($this);
        $this->enrollments[] = $enrollment;       
    }

    public function calcSubTotal() : AmountVO {
        //$subTot   = 0;
        $subTotVO = new AmountVO(0);

        foreach ($this->enrollments as $enrollment) {
            $courseItem = $enrollment->getCourseItem();            
            // $course     = $courseItem->getCourse();
            // $subTot += $course->getPrice();

            //$subTot += $courseItem->coursePrice();            
            $subTotVO   = $subTotVO->add($courseItem->getRevisedPrice());
        }
        //return n$subTot;
        return $subTotVO;
    }


    public function calcTotal() : AmountVO  {
        //$total = 0;
        $totalVO = new AmountVO(0);
        
        foreach ($this->enrollments as $enrollment) {
            $courseItem  = $enrollment->getCourseItem();
            //$total    += $courseItem->getRevisedPrice()->getV;
            $totalVO     = $totalVO->add($courseItem->getRevisedPrice());
        }
        return $totalVO;
    }

    public function enrollmentCount() : int {
        return count($this->enrollments);
    }


    //todo
    public function isCourseExists(CourseEntity $courseEntity) : bool {
        foreach ($this->enrollments as $enrollment) {
            $courseItem  = $enrollment->getCourseItem();
            
            //$course      = $courseItem->getCourse();
            //if($course->getId == $courseEntity->getId) return true;
            
            if($courseItem->checkGivenCourse($courseEntity)) return true;
        }
        return false;
    }

    /**
    * @param void
    * @return CourseItem
    */
    public function getDiscountedEnrollments() : array {
        $discountedEnrollments = array();
        
        foreach ($this->enrollments as $enrollment) {
            $courseItem  = $enrollment->getCourseItem();
            $cc          = $courseItem->getCouponCode();

            if($cc && $cc->getDiscountPercentage() > 0){
                $course     = $courseItem->getCourse(); 
                if(!$course) continue;               
                $courseId   = $course->getId();

                $ccCourse = $cc->getCourse();
                if(!$ccCourse) continue;  
                $ccCourseId = $ccCourse->getId();

                if($courseId == $ccCourseId){
                    //$discountedItems[] = $courseItem; 
                    $discountedEnrollments[] = $enrollment; 
                }
            }
        }

        return $discountedEnrollments;
    }


	public function totalEdumindEarnaAmount()  : AmountVO  {
        //$totEdumind = 0;
        $totEdumindVO = new AmountVO(0);

        foreach ($this->enrollments as $enrollment) {
            $courseItem     = $enrollment->getCourseItem();
            //$totEdumind += $courseItem->edumindNetAmount();
            $totEdumindVO   = $totEdumindVO->add($courseItem->edumindNetAmount());
        }

        //return $totEdumind; 
        return $totEdumindVO;    
    }
	


    //-----------------todo -if cc applies to courseItem
    public function earnAmountByAuthor(TeacherUserEntity $givenTeacher) : AmountVO {
        //$totAuthor    = 0;
        $totAuthorVO    = new AmountVO(0);
        
        foreach ($this->enrollments as $enrollment) {
            /*
            $courseItem = $enrollment->getCourseItem();
            $course     = $courseItem->getCourse();
            $author     = $course->getAuthor();
            if(!$author) continue;
    
            if($author->getId() == $givenTeacher->getId())
                $totAuthor += $course->getPrice()*($course->getAuthorSharePercentage()/100);
            */  

            $course     = $enrollment->course();            
            $author     = $course->getAuthor();
            if(!$author) continue;
    
            if($author->getId() == $givenTeacher->getId()){
                //$totAuthor   += $course->getPrice()*($course->getAuthorSharePercentage()/100);
                $earnAmount     = $course->getPrice()->multiply($course->getAuthorSharePercentage()->asFraction()) ;
                $totAuthorVO    = $totAuthorVO->add($earnAmount);
            }
        }
        //return $totAuthor; 
        return $totAuthorVO; 
    }
	
    public function totalDiscount() : AmountVO {
        //$discount     = 0;
        $discountVO     = new AmountVO(0);

        foreach ($this->enrollments as $enrollment) {
            //$courseItem = $enrollment->getCourseItem();
            //$discount  += $courseItem->getCourse()->getPrice() - $courseItem->getRevisedPrice();
            
            $courseItem   = $enrollment->getCourseItem();
            //$discount  += $enrollment->course()->getPrice() - $courseItem->getRevisedPrice();            
            $discount     = $enrollment->course()->getPrice()->subtract($courseItem->getRevisedPrice());
            $discountVO   = $discountVO->add($discount);
        }
        //return $discount;    
        return $discountVO;    
    }
	

    public function getBeneficiary() : array {
        $beneficiaryArr = array();
        foreach ($this->enrollments as $enrollment) {
            
            //$courseItem         = $enrollment->getCourseItem();
            //$courseItemCoupon   = $courseItem->getCouponCode();
            //if(!$courseItemCoupon) continue;
            //$beneficiaryArr[] = $courseItemCoupon->getBeneficiary();

            $beneficiaryArr[] = $enrollment->beneficiary();
        }
        return $beneficiaryArr[0];
    }

	public function getBeneficiaryEarnAmount() : AmountVO {

    }

	public function freeCourseEnroll() {

    }

	public function paidCourseEnroll() {

    }

}

//use App\Domain\ValueObjects\PercentageVO;
//use App\Domain\ValueObjects\AmountVO;
//use App\Domain\ValueObjects\DateTimeVO;


//public function removeOrderItem(){}
