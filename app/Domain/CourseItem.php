<?php


namespace App\Domain;
use App\Domain\Types\CourseItemTypesEnum;


class CourseItem{
	
    private $id;
    private $uuid;
    private $cartAddedDate;
    private $isCheckout;

    private $discountAmount;
    private $edumindLoseAmount;
    private $revisedPrice;
    private $edumindAmount;


    public function __construct(Course $course, $cartAddedDate, $isCheckout) {
        $this->course        = $course;
        $this->cartAddedDate = $cartAddedDate;
        $this->isCheckout    = $isCheckout;
        

        $this->edumindAmount    = $this->course->getPrice()*(100 - $this->course->getAuthorSharePercentage/100);
        //$this->authorAmount   = $this->course->getPrice()*($this->course->getAuthorSharePercentage/100);
        
        $this->discountAmount      = 0;
        //$this->beneficiaryCommisionPercentageFromDiscount = 0;

        $this->revisedPrice = $course->getPrice();

        $this->edumindLoseAmount     = 0;
        //$this->beneficiaryEarnAmount = 0;
    }



    /* associations */
    protected Course $course;
    protected CouponCode $couponCode;
    
    /*
    public function setCourse(Course $course){
        $this->course = $course;
    }
    */    

    public function getCourse(){
        return $this->course;
    }     


    public function setCouponCode(CouponCode $couponCode){
        $this->couponCode = $couponCode;
    
        $this->discountAmount   = $this->course->getPrice() * $this->couponCode->getDiscountPercentage();
        
        //$this->beneficiaryCommisionPercentageFromDiscount = $couponCode->getBeneficiaryCommisionPercentageFromDiscount();
        $commisionPercentage    = $couponCode->getBeneficiaryCommisionPercentageFromDiscount();
        
        $this->revisedPrice     = $this->course->getPrice() - $this->discountAmount;

        //$this->edumindLoseAmount       = ($this->discountAmount/100) * (100 + $cc->getCommisionPercentageFromDiscount());
        $this->edumindLoseAmount       = ($this->discountAmount/100) * (100 + $commisionPercentage());
        //$this->benificiaryEarnAmount   = $this->discountAmount * ($cc->getCommisionPercentageFromDiscount()/100);
   }

    public function getCouponCode(){
        return $this->couponCode;
    } 







 




    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUuid() {
        return $this->uuid;
    }

    public function getRevisedPrice() {
        return $this->revisedPrice;
    }



    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUuid($uuid) {
        $this->uuid = $uuid;
    }











    public function removeCouponCode(){
        $this->couponCode       = null;    
        $this->discountAmount   = 0;
        $this->revisedPrice     = $this->course->getPrice();
        $this->edumindLoseAmount= 0;
    }



 

    

    public function getCourseItemType(){
        return $this->isCheckout ? 
            CourseItemTypesEnum::ORDER_ITEM : 
            CourseItemTypesEnum::CART_ITEM;
    }




    public function getcartAddedDate(){
        return $this->cartAddedDate;
    }
    // public function getCourse(){}
    

    public function checkCouponWorksforThis(CouponcodeEntity $givenCc){
        $ccAssignedCourse   = $givenCc->getCourse();
        $thisCourseId       = $this->course->getId();
        
        if(!$ccAssignedCourse){
            return true;
        }else{
            if($ccAssignedCourse->getId() == $this->course->getId()){
                return true;
            }else{
                return false;
            }
        }
    } 
    

    public function isCheckout(){
        $course = $this->getCourse();
        return $course->getPrice();   
    }


    public function coursePrice(){
        return $this->isCheckout();    
    }

    public function revisedCoursePrice(){
        return $this->revisedPrice();  
    }
 





    
    


    public function getEdumindAmount(){
        return $this->edumindAmount;
    }
    
    public function getEdumindLooseAmount(){
        return $this->edumindLoseAmount;
    }
    
    public function edumindEarnTotalAmount(){
        return ($this->edumindAmount - $this->edumindLoseAmount);
    }



    
    public function calcDiscount(){
        return $this->$discountAmount;
    }




    // toArray method
    public function toArray()
    {
        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'cartAddedDate' => $this->cartAddedDate,
            'isCheckout'    => $this->isCheckout,

            'edumindAmount'         => $this->edumindAmount,
            //'authorAmount'          => $this->authorAmount,
            'discountAmount'        => $this->discountAmount,
            'revisedPrice'          => $this->revisedPrice,
            'edumindLoseAmount'     => $this->edumindLoseAmount,
            //'beneficiaryEarnAmount' => $this->beneficiaryEarnAmount,

            'course'                => $course->toArray(),
            'couponCode'            => $couponCode->toArray()
        ];
    }

}




















// created_at
// updated_at
// deleted_at 