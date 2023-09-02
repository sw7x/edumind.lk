<?php
namespace App\Domain;

use App\Domain\CourseMessage;
use App\Domain\Interfaces\IEntity;
use App\Domain\Entity;

use App\Domain\Exceptions\AttributeAlreadySetDomainException;

use App\Domain\Course as CourseEntity;
use App\Domain\CourseMessage as CourseMessageEntity;

class CourseThread extends Entity
{
    private ?int     $id    = null;
    private ?string  $uuid  = null;
    

    /* associations */
    private CourseEntity  $course;

    /* @var CourseMessageEntity[] */
    private array         $comments;    
    



    public function __construct(Course $course){
        $this->course   = $course;
        $this->comments = [];
    }

        




    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getCourse() : Course {
        return $this->course;
    }
    
    public function getAllComments() : array {
        return $this->comments;
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
    
    public function setComments(array $comments) : void {
        if ($this->comments !== []) {
            throw new AttributeAlreadySetDomainException('comments attribute already been set and cannot be changed.');
        }
        $this->comments = $comments;
    }




    // toArray method
    public function toArray() : array{
        
        /*$commentArr = [];
        foreach ($this->comments as $comment) {
            $commentArr[] = $comment->toArray();
        }*/

        return [
            'id'             => $this->id,
            'uuid'           => $this->uuid,            
            'course'         => $this->course ? $this->course->toArray() : null,
            'courseComments' => parent::ObjArrConvertToData($this->comments),
        ];
    }



    public function addComment(CourseMessageEntity $comments) : void {
        $this->comments[] = $comments;
    }

    public function removeComment(CourseMessageEntity $comments) : void  {
        
    }

}



