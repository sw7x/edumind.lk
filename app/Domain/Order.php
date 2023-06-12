<?php


namespace App\Domain;



class Order{
	private $id;
    private $uuid;
	private $checkOutDate;
 	
 	public function __construct(array $cartItems) {
       
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

    public function setCheckOutDate($checkOutDate){
        $this->checkOutDate = $checkOutDate;
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

    public function getCheckOutDate(){
        return $this->checkOutDate;
    }


    /* associations */
    protected Invoice $invoice;
    protected User $cartOwner;
    protected $orderItems = array();
    

    public function getInvoice(){
        return $this->invoice;
    }    

    public function getCartOwner(){
        return $this->cartOwner;
    }    

    public function getAllOrderItems(){
        return $this->orderItems;
    }


    public function setInvoice(Invoice $invoice){
        $this->invoice = $invoice;
    }

    public function setCartOwner(User $cartOwner){
        $this->cartOwner = $cartOwner;
    }
    
    // toArray method
    public function toArray()
    {
        return [            
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'checkOutDate'  => $this->checkOutDate,

            'invoice'       => $this->invoice->toArray(),
            'cartOwner'     => $this->cartOwner->toArray(),
            'orderItems'    => $this->orderItems
        ];
    }
    

    /* ===== methods =========*/

    /**
    * @param CourseItem[] $orderItems
    * @return void
    */
    public function setOrderItems($orderItems){
        $this->orderItems[] = $orderItems;
    }

    /**
    * @param CourseItem $orderItems
    * @return void
    */
	public function addOrderItem(CourseItem $orderItem){
        $this->orderItems[] = $orderItem;
    }

    

    public function calcSubTotal() {
        $subTot = 0;
        foreach ($this->orderItems as $courseItem) {
            $course = $courseItem->getCourse();
            $subTot += $course->getPrice();
        }
        return $subTot;
    }


    public function calcTotal() {
        $total = 0;
        foreach ($this->orderItems as $courseItem) {
            $subTot += $courseItem->getRevisedPrice();
        }
        return $total;
    }

    public function orderItemCount() {
        return count($this->orderItems);
    }


    //todo
    public function isCourseExists(courseEntity $courseEntity) {
        foreach ($this->orderItems as $courseItem) {
            $course = $courseItem->getCourse();
            if($course->getId == $courseEntity->getId) return true;
        }

        return false;
    }

    /**
    * @param void
    * @return CourseItem
    */
    public function getDiscountedOrderItems() {
        $discountedItems = array();
        foreach ($this->orderItems as $courseItem) {
            $cc = $courseItem->getCouponCode();

            if($cc && $cc->getDiscountPercentage() > 0){
                $course     = $courseItem->getCourse(); 
                if(!$course) continue;               
                $courseId   = $course->getId();

                $ccCourse = $cc->getCourse();
                if(!$ccCourse) continue;  
                $ccCourseId = $ccCourse->getId();

                if($courseId == $ccCourseId){
                    $discountedItems[] = $courseItem; 
                }
            }
        }

        return $discountedItems;
    }

	public function totalEdumindEarnaAmount() {
        $totEdumind = 0
        foreach ($this->orderItems as $courseItem) {
            $discount += $courseItem->edumindEarnTotalAmount();
        }
        return $totEdumind;    
    }
	
    
    //-----------------todo -if cc applies to courseItem
    public function earnAmountByAuthor(Teacher $givenTeacher) {
        $totAuthor = 0
        foreach ($this->orderItems as $courseItem) {
            $course = $courseItem->getCourse();
            $author = $course->getAuthor()
            if(!$author) continue;
    
            if($author->getId() == $givenTeacher->getId())
                $totAuthor += $course->getPrice()*($course->getAuthorSharePercentage/100);            
        }
        return $totAuthor; 
    }
	
    public function totalDiscount() {
        $discount = 0
        foreach ($this->orderItems as $courseItem) {
            $discount += $courseItem->getCourse()->getPrice() - $courseItem->getRevisedPrice();
        }
        return $discount;    
    }
	

    public function getBenificiary() {
        $benificiaryArr = array();
        foreach ($this->orderItems as $courseItem) {
            $courseItemCoupon = $courseItem->getCouponCode();

            if(!$courseItemCoupon) continue;

            $benificiaryArr[] = $courseItemCoupon->getBenificiary();
        }
        return $benificiaryArr[0];
    }

	public function getBenificiaryEarnAmount() {

    }

	public function freeCourseEnroll() {

    }

	public function paidCourseEnroll() {

    }

}



//public function removeOrderItem(){}