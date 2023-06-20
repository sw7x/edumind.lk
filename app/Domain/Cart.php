<?php
namespace App\Domain;

use App\Domain\CartItem;
use App\Domain\Exceptions\DomainException;
 

class Cart{
	
    private $id;
    private $uuid;
    


    /*
    public function __construct(array $cartItems) {
       
    }
    */

    /* associations */
    protected User $cartOwner;
    protected $courseItems = array();
    

    public function getAllCourseItems(){
        return $this->courseItems;
    }

    public function setCourseItems(array $courseItems){
        $this->courseItems[] = $courseItems;
    }



    public function getCartOwner(){
        return $this->cartOwner;
    }

    public function setCartOwner(User $cartOwner){
        $this->cartOwner = $cartOwner;
    }    

    

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }
    


    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }



    // toArray method
    public function toArray()
    {
        return [            
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            
            'cartOwner'     => $cartOwner->toArray(),
            'courseItems'   => $this->courseItems
        ];
    }






    public function applyCouponCode(CouponCode $cc) {
        $arr = array();
        $ccCourse             = $cc->getCourse();
        $ccDiscountPercentage = $cc->getDiscountPercentage();
        
        foreach ($this->courseItems as $key => $courseItem) {
            $couse = $courseItem->getCourse();
            
            if(!$ccCourse){
                $arr[] = array(
                    'courseItemId'=> $key,
                    'coursePrice' => $couse->getPrice()
                )
            }else{
                if($couse->getId() == $ccCourse->getId()){
                    $arr[] = array(
                        'courseItemId'=> $key,
                        'coursePrice' => $couse->getPrice()
                    )
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
        $selCourseItem->setCouponCode($cc);                
    }

    
    public function removeCouponCode(CouponCode $givenCc) {
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
    




    public function addToCart(CourseItem $courseItem) {
        $this->courseItems[] = $courseItem 
    }
    
    public function removeFromCart(CourseItem $removeCourseItem) {
        foreach ($this->courseItems as $key => $courseItem) {
            if ($courseItem->getId() == $removeCourseItem->getId()) {
                unset($this->courseItems[$key]);
                break;
            }
        }
    }


    public function calcSubTotal() {
        $subTot = 0;
        foreach ($this->courseItems as $courseItem) {
            $course = $courseItem->getCourse();
            $subTot += $course->getPrice();
        }
        return $subTot;
    }


    public function calcTotal() {
        $total = 0;
        foreach ($this->courseItems as $courseItem) {
            $subTot += $courseItem->getRevisedPrice();
        }
        return $total;
    }


    public function checkout() {
        //remove cart items from cart
        //get all cart items
        //update cartItems.isCheckout = true


        //create order
        // CREATE INVOICE
        //SET INVOICE TO Order.invoice



        //add cartItems 2 order



        //create enrollments
        //set this.cartOwner   to all Enrollment.Student
        //set order   to all Enrollment.order
        //set cartItems   to each Enrollment.courseItemS

        //return enrollments


    }


    public function courseCount() {
        return count($this->courseItems);
    }

    public function isCourseExists(Course $course) {
        foreach ($this->courseItems as $courseItem) {
            $course = $courseItem->getCourse();
            if($course->getId == $courseEntity->getId) return true;
        }

        return false;
    }





}



