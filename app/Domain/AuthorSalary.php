<?php


namespace App\Domain;
use App\Domain\Users\TeacherUser as TeacherUserEntity;
use App\Domain\Entity;

use App\Domain\ValueObjects\AmountVO;
use App\Domain\ValueObjects\DateTimeVO;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;
use App\Domain\AuthorFee as AuthorFeeEntity;
use App\Domain\Exceptions\DomainException;


class AuthorSalary extends Entity{
	
	
    private ?int        $id         = null;
    private ?string     $uuid       = null;
    private string      $image;
    private AmountVO    $paidAmount;
    private DateTimeVO  $paidDate;
    private ?string     $remarks    = null;
    private DateTimeVO  $fromDate;
    private DateTimeVO  $toDate;    

    
    /* associations */
    private TeacherUserEntity $author;
    
    /* @var AuthorFeeEntity[] */
    private array            $fees;



    public function __construct(
        TeacherUserEntity   $author,
        AmountVO            $paidAmount, 
        
        array               $fees    = [],
        
        string              $image, 
        DateTimeVO          $paidDate, 
        string              $remarks = null,
        DateTimeVO          $fromDate, 
        DateTimeVO          $toDate
    ){
        $this->author       = $author;
        $this->paidAmount   = $paidAmount;
        
        $this->fees         = $fees;
        
        $this->image        = $image;        
        $this->paidDate     = $paidDate;
        $this->remarks      = $remarks;
        $this->fromDate     = $fromDate;
        $this->toDate       = $toDate;
        
        if(!$fromDate->isBefore($toDate))
            throw new DomainException("The fromDate needs to come before the toDate.");

        if(!$paidDate->isAfter($toDate) && !$paidDate->isEqual($toDate))
            throw new DomainException("The paidDate must be later than or equal to the toDate.");            
    }


    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getImage() : string {
        return $this->image;
    }

    public function getPaidAmount() : AmountVO {
        return $this->paidAmount;
    }

    public function getPaidDate() : DateTimeVO {
        return $this->paidDate;
    }

    public function getRemarks() : ?string {
        return $this->remarks;
    }

    public function getFromDate() : DateTimeVO {
        return $this->fromDate;
    }

    public function getToDate() : DateTimeVO {
        return $this->toDate;
    }    
    
    public function getAuthor() : TeacherUserEntity {
        return $this->author;
    }

    public function getAllFees() : array {
        return $this->fees;
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
    
    
    


    // toArray method
    public function toArray() : array {

        /*$feeArr = [];
        foreach ($this->fees as $fee) {
            $feeArr[] = $fee->toArray();
        }*/

        return [            
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'image'         => $this->image,
            'paidAmount'    => $this->paidAmount->getValue(),
            'paidDate'      => $this->paidDate->format(),
            'remarks'       => $this->remarks,
            'fromDate'      => $this->fromDate->format(),
            'toDate'        => $this->toDate->format(),
            
            'fees'    => parent::ObjArrConvertToData($this->fees),            
            
            'authorArr'     => $this->author ? $this->author->toArray() : null,
            'authorId'      => $this->author ? $this->author->getId()   : null
        ];
    }


    public function calculateSubTotal() : AmountVO {
        //return $this->subTotal;
        $subTotal = new AmountVO(0);
        
        foreach ($this->fees as $fee) {
            if (!($fee instanceof AuthorFeeEntity)) {
                throw new DomainException('Array contains objects that are not AuthorFee Entities.');
            }
            $subTotal->add($fee->getAmount());
        }
        return $subTotal;
    }

	
}
