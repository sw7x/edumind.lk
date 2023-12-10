<?php

namespace App\Domain;

use App\Domain\ValueObjects\AmountVO;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;
use App\Domain\Entity;
use App\Domain\Course as CourseEntity;

abstract class AbstractCourseItem extends Entity{
    
    protected ?int        $id   = null;
    protected ?string     $uuid = null;
    protected AmountVO    $revisedPrice;    


    protected AmountVO    $edumindAmount;
    protected AmountVO    $authorAmount;    
    protected AmountVO    $discountAmount;
    protected AmountVO    $edumindLoseAmount;
    protected AmountVO    $beneficiaryEarnAmount;



    /* associations */
    protected CourseEntity $course;

    


    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }
    
    public function getBeneficiaryEarnAmount() : AmountVO {
        return $this->beneficiaryEarnAmount;
    } 
    
    public function getAuthorAmount() : AmountVO {
        return $this->authorAmount;
    }
    
    public function getEdumindAmount() : AmountVO {
        return $this->edumindAmount;
    }
    
    public function getEdumindLooseAmount() : AmountVO {
        return $this->edumindLoseAmount;
    }
    
    public function getCourse() : CourseEntity {
        return $this->course;
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
    abstract public function toArray() : array; 


    public function coursePrice() : AmountVO {
        $course = $this->getCourse();
        return $course->getPrice();       
    }

    public function edumindNetAmount() : AmountVO {
        return $this->edumindAmount->subtract($this->edumindLoseAmount);
    }

    public function checkGivenCourse(CourseEntity $givenCourse) : bool {
        return ($givenCourse->getId() == $this->course->getId());
    }

    public function calcDiscount() : AmountVO {
        return $this->discountAmount;
    }
    
    abstract public function revisedPrice() : AmountVO; 


}
