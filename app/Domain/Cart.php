<?php
namespace App\Domain;

use App\Domain\CourseItem as CourseItemEntity;
use App\Domain\CouponCode as CouponCodeEntity;
use App\Domain\Users\StudentUser as StudentUserEntity;
use App\Domain\Course as CourseEntity;
use App\Domain\Order as OrderEntity;
use App\Domain\Enrollment as EnrollmentEntity;

use App\Domain\Exceptions\DomainException;
use App\Domain\Entity;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;
use App\Domain\ValueObjects\AmountVO;
use App\Domain\ValueObjects\DateTimeVO;

//use App\Domain\Invoice as InvoiceEntity;
//use App\Domain\Exceptions\InvalidCouponException;


class Cart extends Entity{
    
    /* associations */
    /* @var CourseItemEntity[] */
    private array $courseItems;


    public function __construct() {
        $this->courseItems = [];
    }
    

    //GETTERS
    public function getAllCourseItems() : array {
        return $this->courseItems;
    }

    
    //SETTERS
    public function setCourseItems(array $courseItems) : void {
        if ($this->courseItems !== []) {
            throw new AttributeAlreadySetDomainException('courseItems attribute already been set and cannot be changed.');
        }
        $this->courseItems = $courseItems;
    }



    // toArray method
    public function toArray() : array {
        return parent::ObjArrConvertToData($this->courseItems);
    }




    public function addToCart(CourseItemEntity $courseItem) : void {
        $this->courseItems[] = $courseItem;
    }

    public function removeFromCart(CourseItemEntity $removeCourseItem)  : void {
        foreach ($this->courseItems as $key => $courseItem) {
            if ($courseItem->getId() == $removeCourseItem->getId()) {
                unset($this->courseItems[$key]);
                break;
            }
        }
    }

    public function calcSubTotal() : AmountVO {
        $subTot = new AmountVO(0);
        foreach ($this->courseItems as $courseItem) {
            $course = $courseItem->getCourse();
            $subTot = $subTot->add($course->getPrice());
        }
        return $subTot;
    }

    public function calcTotal() : AmountVO {
        $total = new AmountVO(0);
        foreach ($this->courseItems as $courseItem) {
            $revisedPrice   =   $courseItem->getRevisedPrice();
            $total          =   $total->add($revisedPrice);
        }
        return $total;
    }

    /* check coupon code can apply to the cart */
    public function canCouponUse(CouponCodeEntity $givenCc) : void {

        if($this->isCouponUsed($givenCc))
            throw new DomainException("Coupon code already used in your cart");

        if($this->appliedCouponCodeCount() > 0)
            throw new DomainException("Sorry, you can't use more than one coupon code at a time.");

        $ccCourse   = $givenCc->getCourse();
        $canUse     = false;
        
        $ccCanApplyCartItems = [];
        foreach ($this->courseItems as $key => $courseItem) {
            $cartItemCourse =   $courseItem->getCourse();
            $canUse         =   is_null($ccCourse) ?
                                    true :
                                    ($cartItemCourse->getId() === $ccCourse->getId() ? true : false);

            if($canUse)
                $ccCanApplyCartItems[]  =   $courseItem;            
        
        }

        if(empty($ccCanApplyCartItems)){
            throw new DomainException("Sorry, the given coupon code is not valid for any of the courses in your cart.");
        
        }else{            
            $edumindHaveNetAmountCartItems = [];
            foreach ($ccCanApplyCartItems as $cartItem) {                
                $canEarn = $cartItem->canEdumindEarnAfterUsingCoupon($givenCc);                 
                if($canEarn)
                    $edumindHaveNetAmountCartItems[]  =   $courseItem;
            }
            
            if(empty($edumindHaveNetAmountCartItems)){
                $courseNames = '';
                $loopCount = 0;
                foreach ($ccCanApplyCartItems as $cartItem) {
                    $loopCount++;
                    $course       = $courseItem->getCourse();
                    $courseName   = $course->getName();
                    $courseNames .= ($ccCanApplyCartItems[0] == $cartItem) ? $courseName : ', '.$courseName;                   

                }
                $courseNames .= ($loopCount > 1) ? ' courses' : ' course';

                throw new DomainException("Sorry, Coupon code is valid for {$courseNames} but cannot apply due to edumind net amount cannot be zero to single course policy.");
            }
        }

    }


    /* check coupon code already used in cart */
    public function isCouponUsed(CouponCodeEntity $givenCc) : bool {
        foreach ($this->courseItems as $key => $courseItem) {
            $cc = $courseItem->getCouponCode();
            if(!is_null($cc)){
               if($cc->getCode() === $givenCc->getCode()){
                return true;
               }
            }
        }
        return false;
    }

    /* get how many coupon codes were applied to the cart */
    public function appliedCouponCodeCount() : int {
        $count = 0;
        foreach ($this->courseItems as $key => $courseItem) {
            $cc = $courseItem->getCouponCode();
            if(!is_null($cc))
               $count++;
        }
        return $count;
    }

    public function applyCouponCode(CouponCodeEntity $cc) : void {
        if(!$cc)
            throw new DomainException('CouponCode was not given');

        if(empty($this->courseItems))
            throw new DomainException("Your cart is empty right now, which means we can't apply the coupon code.");

        $ccCourse             = $cc->getCourse();
        $ccDiscountPercentage = $cc->getDiscountPercentage();

        $arr = array();
        foreach ($this->courseItems as $key => $courseItem) {
            $course = $courseItem->getCourse();

            if(!$ccCourse){
                $arr[] = array(
                    'courseItemId'=> $key,
                    'coursePrice' => $course->getPrice()
                );
            }else{
                if($course->getId() == $ccCourse->getId()){
                    $arr[] = array(
                        'courseItemId'=> $key,
                        'coursePrice' => $course->getPrice()
                    );
                }
            }

        }

        if(empty($arr))
            throw new DomainException("Coupon code not valid for courses in your cart.");
    
        $edCanEarnItems = [];
        foreach ($arr as $arrItem) {                
            $index      =   $arrItem['courseItemId'];
            $courseItem =   $this->courseItems[$index];

            $canEarn    =   $courseItem->canEdumindEarnAfterUsingCoupon($cc);                 
            if($canEarn)
                $edCanEarnItems[]  =   $this->courseItems[$index];
        }


        if(empty($edCanEarnItems)){
            $courseNames    = '';
            $loopCount      = 0;
            foreach ($ccCanApplyCartItems as $cartItem) {
                $loopCount++;
                $course       = $courseItem->getCourse();
                $courseName   = $course->getName();
                $courseNames .= ($ccCanApplyCartItems[0] == $cartItem) ? $courseName : ', '.$courseName;                
            }
            
            $courseNames .= ($loopCount > 1) ? ' courses' : ' course';
            throw new DomainException("Sorry, Coupon code is valid for {$courseNames} but cannot apply due to edumind net amount cannot be zero to single course policy.");
        
        }else{

            // Sort the array by the coursePrice key
            usort($edCanEarnItems, function($a, $b) {               
                $priceA = $a->getCourse()->getPrice()->getValue();
                $priceB = $b->getCourse()->getPrice()->getValue();
                return  $priceB - $priceA;
                //return ($b['coursePrice'])->getValue() - ($a['coursePrice'])->getValue();
            });

            /* for apply coupon to the course that has 2nd highest price */
            $selCourseItemId  =  (count($edCanEarnItems) > 1) ? 1 : 0;
            $selCourseItem    =  $edCanEarnItems[$selCourseItemId];            
            $selCourseItem->applyCouponCode($cc);
        }        
    }


    public function removeCouponCode(CouponCodeEntity $givenCc) : void {
        if(!$givenCc)
            throw new DomainException('CouponCode was not given');

        foreach ($this->courseItems as $key => $courseItem) {
            $courseItemAssignedCc = $courseItem->getCouponCode();

            if(!$courseItemAssignedCc) continue;

            if($givenCc->getCode() == $courseItemAssignedCc->getCode()){
                $courseItem->removeCouponCode();
            }
        }
    }


    public function removeAllCoupons() : void {
        if(empty($this->courseItems))
            throw new DomainException("Your cart is empty right now, which means we can't remove applied coupon codes.");

        foreach ($this->courseItems as $key => $courseItem) {
            $courseItem->removeCouponCode();
        }
    }



    public function checkout(StudentUserEntity $cartOwner, array $invoicData) : OrderEntity {
        //get all cart items to variable
        $courseItems = $this->courseItems;

        //remove cart items from cart
        $this->courseItems = [];
        
        //update cartItems.isCheckout = true and create Enrollments
        $enrollmentArr = [];
        foreach ($courseItems as $courseItem) {
            $courseItem->markAsCheckout();
            
            $enrollmentObj   = new EnrollmentEntity($courseItem, $cartOwner);
            $enrollmentObj->setIsComplete(false);
            $enrollmentArr[] = $enrollmentObj;           
        }

        //create order
        $order = new OrderEntity($enrollmentArr, $cartOwner);
        $order->setCheckOutDate(new DateTimeVO($invoicData['checkoutDate']));

        //create Invoice
        $order->createInvoice($invoicData);
        
        return $order;
    }

    
    public function courseCount() : int {
        return count($this->courseItems);
    }

    public function isCourseExists(CourseEntity $course) : bool {
        foreach ($this->courseItems as $courseItem) {
            $course = $courseItem->getCourse();
            if($course->getId == $courseEntity->getId) return true;
        }

        return false;
    }

}