<?php


namespace App\Domain;



class CourseItem{
	
	private $id;
    private $uuid;
    private $cartAddedDate;
    private $isCheckout;

    private $edumindAmount;
    private $authorAmount;

    private $discountAmount;
    //private $beneficiaryCommisionPercentageFromDiscount;


    private $revisedPrice;
    private $edumindLoseAmount;
    private $beneficiaryEarnAmount;
    

    
	public function __construct(Course $course, Student $student, $cartAddedDate, $isCheckout) {
		$this->course 		 = $course;
		$this->student 		 = $student;
		$this->cartAddedDate = $cartAddedDate;
		$this->isCheckout 	 = $isCheckout;
		

		$this->edumindAmount 	= $this->course->getPrice()*($this->course->getAuthorSharePercentage/100);
		$this->authorAmount 	= $this->course->getPrice()*(100 - $this->course->getAuthorSharePercentage/100);
		
		$this->discountAmount      = 0;
		//$this->beneficiaryCommisionPercentageFromDiscount = 0;

		$this->revisedPrice = $course->getPrice();

		$this->edumindLoseAmount 	 = 0;
		$this->beneficiaryEarnAmount = 0;


	}
	



	/* associations */
    protected Course $course;
	
	public function getCourse(){
        return $this->course;
    }
    /*public function setCourse(Course $course){
        $this->course = $course;

        $this->edumindAmount 	= $this->course->price*($this->course->authorSharePercentage/100);
		$this->authorAmount 	= $this->course->price*(100 - $this->course->authorSharePercentage/100);
    }*/	
	

	protected CouponCode $couponCode;

    public function getCouponCode(){
        return $this->couponCode;
    }




    public function setCouponCode(CouponCode $cc){
        $this->couponCode = $cc;
    
		$this->discountAmount 	= $this->course->getPrice() * $this->couponCode->getDiscountPercentage();
        $this->beneficiaryCommisionPercentageFromDiscount = $couponCode->getBeneficiaryCommisionPercentageFromDiscount();
		
		$this->revisedPrice 	= $this->course->getPrice() - $this->discountAmount;

		$this->edumindLoseAmount       = ($this->discountAmount/100) * (100 + $cc->getCommisionPercentageFromDiscount());
		$this->benificiaryEarnAmount   = $this->discountAmount * ($cc->getCommisionPercentageFromDiscount()/100);
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

    /*
    public function setCartAddedDate($cartAddedDate)
    {
        $this->cartAddedDate = $cartAddedDate;
    }

    public function setIsCheckout($isCheckout)
    {
        $this->isCheckout = $isCheckout;
    }

    public function setEdumindAmount($edumindAmount)
    {
        $this->edumindAmount = $edumindAmount;
    }

    public function setAuthorAmount($authorAmount)
    {
        $this->authorAmount = $authorAmount;
    }
    

    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
    }

    public function setRevisedPrice($revisedPrice)
    {
        $this->revisedPrice = $revisedPrice;
    }

    public function setEdumindLoseAmount($edumindLoseAmount)
    {
        $this->edumindLoseAmount = $edumindLoseAmount;
    }

    public function setBeneficiaryEarnAmount($beneficiaryEarnAmount)
    {
        $this->beneficiaryEarnAmount = $beneficiaryEarnAmount;
    }

    */


    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getCartAddedDate()
    {
        return $this->cartAddedDate;
    }

    public function getIsCheckout()
    {
        return $this->isCheckout;
    }

    public function getEdumindAmount()
    {
        return $this->edumindAmount;
    }

    public function getAuthorAmount()
    {
        return $this->authorAmount;
    }

    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    public function getRevisedPrice()
    {
        return $this->revisedPrice;
    }

    public function getEdumindLoseAmount()
    {
        return $this->edumindLoseAmount;
    }

    public function getBeneficiaryEarnAmount()
    {
        return $this->beneficiaryEarnAmount;
    }
    

    // toArray method
    public function toArray()
    {
        return [
            'id' 			=> $this->id,
            'uuid' 			=> $this->uuid,
            'cartAddedDate' => $this->cartAddedDate,
            'isCheckout' 	=> $this->isCheckout,

            'edumindAmount' 		=> $this->edumindAmount,
            'authorAmount' 			=> $this->authorAmount,
            'discountAmount' 		=> $this->discountAmount,
            'revisedPrice' 			=> $this->revisedPrice,
            'edumindLoseAmount' 	=> $this->edumindLoseAmount,
            'beneficiaryEarnAmount' => $this->beneficiaryEarnAmount,

        ];
    }
}















//id
//uuid
//cart_added_date
//is_checkout
course_id  ==>FK
student_id ==>FK
used_coupon_code==>FK


edumind_amount
author_amount

discount_amount
revised_price
edumind_lose_amount
benificiary_earn_amount






created_at
updated_at
deleted_at 