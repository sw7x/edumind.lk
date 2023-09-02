<?php
namespace App\DataTransferObjects;

use App\DataTransferObjects\CourseItemDTO;
use App\DataTransferObjects\UserDTO;

use App\DataTransferObjects\AuthorFeeDTO;
use App\DataTransferObjects\CommissionFeeDTO;
use App\DataTransferObjects\EdumindFeeDTO;

use App\DataTransferObjects\AbstractDto;


class EnrollmentDto extends AbstractDto{
    
    //public read only
    private CourseItemDTO     $courseItemDTO;
    private UserDTO           $studentDTO;

    private ?int              $id;
    //private ?string           $uuid;
    private ?bool             $isComplete;
    private ?string           $completeDate;
    private ?int              $rating;    
    
    private ?AuthorFeeDTO     $authorFeeDTO;
    private ?CommissionFeeDTO $commissionFeeDTO;
    private ?EdumindFeeDTO    $edumindFeeDTO;

    // Constructor
    public function __construct(
        CourseItemDTO     $courseItemDTO,
        UserDTO           $studentDTO,
        
        ?int              $id               = null,
        //?string           $uuid             = null,
        ?bool             $isComplete       = null,
        ?string           $completeDate     = null,
        ?int              $rating           = null,
        
        ?AuthorFeeDTO     $authorFeeDTO     = null,
        ?CommissionFeeDTO $commissionFeeDTO = null,
        ?EdumindFeeDTO    $edumindFeeDTO    = null
    ) {
        $this->courseItemDTO                = $courseItemDTO;
        $this->studentDTO                   = $studentDTO;

        $this->id                           = $id;
        //$this->uuid                         = $uuid;
        $this->isComplete                   = $isComplete;
        $this->completeDate                 = $completeDate;
        $this->rating                       = $rating;

        $this->authorFeeDTO                 = $authorFeeDTO;
        $this->commissionFeeDTO             = $commissionFeeDTO;
        $this->edumindFeeDTO                = $edumindFeeDTO;
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

    
    public function getCourseItemDTO() : CourseItemDTO {
        return $this->courseItemDTO;
    }

    public function getStudentDTO() : StudentDTO {
        return $this->studentDTO;
    }


    public function getAuthorFeeDTO() : ?AuthorFeeDTO {
        return $this->authorFeeDTO;
    }

    public function getCommissionFeeDTO() : ?CommissionFeeDTO {
        return $this->commissionFeeDTO;
    }

    public function getEdumindFeeDTO() : ?EdumindFeeDTO {
        return $this->edumindFeeDTO;
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
            
            'courseItemArr'     => $this->courseItemDTO->toArray(),
            'courseItemId'      => $this->courseItemDTO->getId(),
            
            'studentArr'        => $this->studentDTO->toArray(),
            'studentId'         => $this->studentDTO->getId(),
            
            'authorFeeArr'      => $this->authorFeeDTO->toArray(),
            'commissionFeeArr'  => $this->commissionFeeDTO->toArray(),
            'edumindFeeArr'     => $this->edumindFeeDTO->toArray(),
        ];
    }

    
    
}