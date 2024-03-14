<?php

namespace App\Domain;
use App\Domain\Interfaces\IEntity;
use App\Domain\Entity;

//use Carbon\Carbon;

use App\Domain\ValueObjects\AmountVO;
use App\Domain\ValueObjects\DateTimeVO;

use App\Domain\Exceptions\AttributeAlreadySetDomainException;
use App\Domain\Exceptions\DomainException;

class Invoice extends Entity
{
    private ?int        $id           = null;
    private ?string     $uuid         = null;
    private ?DateTimeVO $checkoutDate = null;
    private ?array      $billingInfo  = null;
    private ?AmountVO   $paidAmount   = null;
        
    public function __construct() {
    
    }
    

    // Getters
    public function getId() : ?int {
        return $this->id;
    }
    
    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getCheckoutDate() : ?DateTimeVO {
        return $this->checkoutDate;
    }

    public function getBillingInfo() : ?array {
        return $this->billingInfo;
    }    

    public function getPaidAmount() : ?AmountVO {
        return $this->paidAmount;
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

    public function setCheckoutDate(DateTimeVO $checkoutDate) : void {
        $this->checkoutDate = $checkoutDate;
    }

    public function setBillingInfo(?array $billingInfo) : void {
        $this->billingInfo = $billingInfo;
    }

    public function setPaidAmount(AmountVO $paidAmount) : void {
        if($paidAmount->getValue() <= 0)
            throw new DomainException("paidAmount cannot be less than zero");

        $this->paidAmount = $paidAmount;
    }


    // toArray method
    public function toArray():array{
        return [
            'id' 			=> $this->id,
            'uuid' 			=> $this->uuid,
            'checkoutDate' 	=> $this->checkoutDate  ? $this->checkoutDate->format() : null,
            'billingInfo' 	=> $this->billingInfo,
            'paidAmount'    => $this->paidAmount    ? $this->paidAmount->getValue() : null,
        ];
    }
}