<?php


namespace App\Domain;



course_id ==>
beneficiary_id ==>

created_at 
updated_at 
//deleted_at





class CouponCode
{
    private $code;
    private $discountPercentage;
    private $commisionPercentageFromDiscount;
    private $totalCount;
    private $usedCount;
    private $isEnabled;
    


    

    // Setters
    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setDiscountPercentage($discountPercentage)
    {
        $this->discountPercentage = $discountPercentage;
    }

    public function setCommisionPercentageFromDiscount($commisionPercentageFromDiscount)
    {
        $this->commisionPercentageFromDiscount = $commisionPercentageFromDiscount;
    }

    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }

    public function setUsedCount($usedCount)
    {
        $this->usedCount = $usedCount;
    }

    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;
    }

    public function setBeneficiaryId($beneficiaryId)
    {
        $this->beneficiaryId = $beneficiaryId;
    }

    // Getters
    public function getDiscountPercentage()
    {
        return $this->discountPercentage;
    }

    public function getCommisionPercentageFromDiscount()
    {
        return $this->commisionPercentageFromDiscount;
    }

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function getUsedCount()
    {
        return $this->usedCount;
    }

    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    public function getCourseId()
    {
        return $this->courseId;
    }

    public function getBeneficiaryId()
    {
        return $this->beneficiaryId;
    }

    // toArray method
    public function toArray()
    {
        return [
            'code' => $this->code,
            'discountPercentage' => $this->discountPercentage,
            'commisionPercentageFromDiscount' => $this->commisionPercentageFromDiscount,
            'totalCount' => $this->totalCount,
            'usedCount' => $this->usedCount,
            'isEnabled' => $this->isEnabled,
            'courseId' => $this->courseId,
            'beneficiaryId' => $this->beneficiaryId,
        ];
    }
}
