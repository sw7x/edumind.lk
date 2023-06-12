<?php


namespace App\Domain;



class AuthorSalary{
	
	
    private $id;
    private $uuid;
    private $image;
    private $paidAmount;
    private $paidDate;
    private $remarks;
    private $fromDate;
    private $toDate;
    private $subTotal;




    /* associations */
    protected Teacher $author;
    protected $fees = array();

    public function getAllFees(){
        return $this->fees;
    }

    public function setComments(array $feeArr){
        $this->fees[] = $feeArr;
    }


    public function getAuthor(){
        return $this->author;
    }

    public function setAuthor(Teacher $author){
        $this->author = $author;
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

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setPaidAmount($paidAmount)
    {
        $this->paidAmount = $paidAmount;
    }

    public function setPaidDate($paidDate)
    {
        $this->paidDate = $paidDate;
    }

    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    }

    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    }

    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
    }    

    /*public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;
    }*/



    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    public function getPaidDate()
    {
        return $this->paidDate;
    }

    public function getRemarks()
    {
        return $this->remarks;
    }

    public function getFromDate()
    {
        return $this->fromDate;
    }

    public function getToDate()
    {
        return $this->toDate;
    }    

    public function calculateSubTotal()
    {
        return $this->subTotal;
    }




    // toArray method
    public function toArray()
    {
        return [            
            'id'        => $this->id,
            'uuid'      => $this->uuid,
            'image'     => $this->image,
            'paidAmount'=> $this->paidAmount,
            'paidDate'  => $this->paidDate,
            'remarks'   => $this->remarks,
            'fromDate'  => $this->fromDate,
            'toDate'    => $this->toDate,
            'subTotal'  => $this->subTotal,
            
            'fees'      => $this->fees,
            'author'    => $this->author->toArray(),
        ];
    }




    public function paySalary($paidAmount, $image, $paidDate, $remarks, $fromDate, $toDate)
    {
        $this->image        = $image;
        $this->paidAmount   = $paidAmount;
        $this->paidDate     = $paidDate;
        $this->remarks      = $remarks;
        $this->fromDate     = $fromDate;
        $this->toDate       = $toDate;

        //return $this
    }



	
}




// created_at 
// updated_at 
// deleted_at