<?php
namespace App\DataTransferObjects;

use App\DataTransferObjects\CourseItemDto;
use App\DataTransferObjects\UserDto;

use App\DataTransferObjects\AuthorFeeDto;
use App\DataTransferObjects\CommissionFeeDto;
use App\DataTransferObjects\EdumindFeeDto;

use App\DataTransferObjects\AbstractDto;


class EnrollmentDto extends AbstractDto{
    
    //public read only
    private CourseItemDto     $courseItemDto;
    private UserDto           $studentDto;

    private ?int              $id;
    //private ?string           $uuid;
    private ?bool             $isComplete;
    private ?string           $completeDate;
    private ?int              $rating;    
    
    private ?AuthorFeeDto     $authorFeeDto;
    private ?CommissionFeeDto $commissionFeeDto;
    private ?EdumindFeeDto    $edumindFeeDto;

    // Constructor
    public function __construct(
        CourseItemDto     $courseItemDto,
        UserDto           $studentDto,
        
        ?int              $id               = null,
        //?string           $uuid             = null,
        ?bool             $isComplete       = null,
        ?string           $completeDate     = null,
        ?int              $rating           = null,
        
        ?AuthorFeeDto     $authorFeeDto     = null,
        ?CommissionFeeDto $commissionFeeDto = null,
        ?EdumindFeeDto    $edumindFeeDto    = null
    ) {
        $this->courseItemDto                = $courseItemDto;
        $this->studentDto                   = $studentDto;

        $this->id                           = $id;
        //$this->uuid                         = $uuid;
        $this->isComplete                   = $isComplete;
        $this->completeDate                 = $completeDate;
        $this->rating                       = $rating;

        $this->authorFeeDto                 = $authorFeeDto;
        $this->commissionFeeDto             = $commissionFeeDto;
        $this->edumindFeeDto                = $edumindFeeDto;
    }

    
    
    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    /*public function getUuid() : ?string {
        return $this->uuid;
    }*/

    public function getIsComplete() : ?bool {
        return $this->isComplete;
    }

    public function getCompleteDate() : ?string {
        return $this->completeDate;
    }

    public function getRating() : ?int {
        return $this->rating;
    }

    
    public function getCourseItemDto() : CourseItemDto {
        return $this->courseItemDto;
    }

    public function getStudentDto() : UserDto {
        return $this->studentDto;
    }


    public function getAuthorFeeDto() : ?AuthorFeeDto {
        return $this->authorFeeDto;
    }

    public function getCommissionFeeDto() : ?CommissionFeeDto {
        return $this->commissionFeeDto;
    }

    public function getEdumindFeeDto() : ?EdumindFeeDto {
        return $this->edumindFeeDto;
    }



    // To Array Method
    public function toArray(): array
    {
        return [
            'id'                => $this->id,
            //'uuid'              => $this->uuid,
            'isComplete'        => $this->isComplete,
            'completeDate'      => $this->completeDate,
            'rating'            => $this->rating,
            
            'courseItemArr'     => $this->courseItemDto->toArray(),
            'courseItemId'      => $this->courseItemDto->getId(),
            
            'studentArr'        => $this->studentDto->toArray(),
            'studentId'         => $this->studentDto->getId(),
            
            'authorFeeArr'      => $this->authorFeeDto->toArray(),
            'commissionFeeArr'  => $this->commissionFeeDto->toArray(),
            'edumindFeeArr'     => $this->edumindFeeDto->toArray(),
        ];
    }

    
    
}