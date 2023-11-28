<?php
namespace App\Domain;

use App\Domain\CourseItem as CourseItemEntity;
use App\Domain\CouponCode as CouponCodeEntity;
use App\Domain\StudentUser as StudentUserEntity;
use App\Domain\Course as CourseEntity;

use App\Domain\Exceptions\DomainException;
use App\Domain\Entity;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;
use App\Domain\ValueObjects\AmountVO;



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
        
        /*
        $courseItemArr = [];
        foreach ($this->courseItems as $courseItem) {
            $courseItemArr[] = $courseItem->toArray();
        }
        */

        /*
        return [
            //'id'            => $this->id,
            //'uuid'          => $this->uuid,

            //'cartOwner'     => $this->cartOwner ? $this->cartOwner->toArray() : [],
            //'courseItems'   => $this->courseItems ? $this->courseItems->toArray() : [],
            //'courseItems'     => parent::ObjArrConvertToData($this->courseItems),
            parent::ObjArrConvertToData($this->courseItems),
        ];
        */


        return parent::ObjArrConvertToData($this->courseItems);
    }





    public function applyCouponCode(CouponCodeEntity $cc) : void {
        $arr = array();
        $ccCourse             = $cc->getCourse();
        $ccDiscountPercentage = $cc->getDiscountPercentage();

        foreach ($this->courseItems as $key => $courseItem) {
            $course = $courseItem->getCourse();

            if(!$ccCourse){
                $arr[] = array(
                    'courseItemId'=> $key,
                    'coursePrice' => $couse->getPrice()
                );
            }else{
                if($course->getId() == $ccCourse->getId()){
                    $arr[] = array(
                        'courseItemId'=> $key,
                        'coursePrice' => $couse->getPrice()
                    );
                }
            }

        }

        // Sort the array by the coursePrice key
        usort($arr, function($a, $b) {
            return $b['coursePrice'] - $a['coursePrice'];
        });

        /* for apply coupon to the course that has 2nd highest price */
        $selCourseItemId = (count($arr) > 1) ? $arr[1]['courseItemId'] : $arr[0]['courseItemId'];
        $selCourseItem = $this->courseItems[$selCourseItemId];
        $selCourseItem->applyCouponCode($cc);
    }

    public function removeCouponCode(CouponCodeEntity $givenCc) : void {
        if(!$givenCc)
            throw new DomainException('CouponCode was not given');

        foreach ($this->courseItems as $key => $courseItem) {
            $courseItemAssignedCc = $courseItem->getCouponCode();

            if(!$courseItemAssignedCc) continue;

            if($givenCc->getId() == $courseItemAssignedCc->getId()){
                $courseItem->removeCouponCode();
            }
        }
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
            $subTot->add($course->getPrice());
        }
        return $subTot;
    }

    public function calcTotal() : AmountVO {
        $total = new AmountVO(0);
        foreach ($this->courseItems as $courseItem) {
            $total->add($courseItem->getRevisedPrice());
        }
        return $total;
    }

    public function checkout(StudentUserEntity $cartOwner) {
        //get all cart items to variable
        //remove cart items from cart
        //update cartItems.isCheckout = true

        //create order => $order = new Order(cartItems[], $cartOwner)
        // order.createInvoice

        //return order
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