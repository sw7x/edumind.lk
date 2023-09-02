<?php
namespace App\Domain;

use App\Domain\Interfaces\IEntity;
use App\Domain\Entity;
use App\Domain\ValueObjects\DateTimeVO;

use App\Domain\Exceptions\AttributeAlreadySetDomainException;


//subject_id ==>FK
//teacher_id ==>FK


class CourseMessage extends Entity
{
    private ?int        $id     = null;
    private ?string     $uuid   = null;
    private DateTimeVO  $postedDateTime;
    private string      $message;

    public function __construct(
        string      $message, 
        DateTimeVO  $postedDateTime
    ){
        $this->message          = $message;
        $this->postedDateTime   = $postedDateTime;
    }



    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getPostedDateTime() : DateTimeVO {
        return $this->postedDateTime;
    }

    public function getMessage() : string {
        return $this->message;
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
        return [
            'id'             => $this->id,
            'uuid'           => $this->uuid,
            'postedDateTime' => $this->postedDateTime ? $this->postedDateTime->format() : null,
            'message'        => $this->message            
        ];
    }


}