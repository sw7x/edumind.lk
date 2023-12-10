<?php
namespace App\Domain;

use App\Domain\AbstractCourseItem as AbstractCourseItemEntity;
use App\Domain\Course as CourseEntity;
use App\Domain\Users\StudentUser as StudentUserEntity;
use App\Domain\Entity;
use App\Domain\ValueObjects\DateTimeVO;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;

//use App\Domain\Users\User as UserEntity;
//use App\Domain\Interfaces\IEntity;

abstract class AbstractEnrollment extends Entity{

    protected ?int        $id             = null;
    protected ?string     $uuid           = null;
    protected ?bool       $isComplete     = null;
    protected ?DateTimeVO $completeDate   = null;
    protected ?int        $rating         = null;


    /* compositions */
    protected AbstractCourseItemEntity  $courseItem;
    protected StudentUserEntity         $student;

    /* @var CourseMessageEntity[] */
    protected array                     $courseMessages;




    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getIsComplete() : ?bool {
        return $this->isComplete;
    }

    public function getCompleteDate() : ?DateTimeVO {
        return $this->completeDate;
    }

    public function getRating() : ?int {
        return $this->rating;
    }

    public function getCourseItem() : AbstractCourseItemEntity {
        return $this->courseItem;
    }

    public function getStudent() : StudentUserEntity {
        return $this->student;
    }

    public function getCourseMessages() : array {
        return $this->courseMessages;
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

    public function setIsComplete(bool $isComplete) : void {
        $this->isComplete = $isComplete;
    }

    public function setCompleteDate(DateTimeVO $completeDate) : void {
        $this->completeDate = $completeDate;
    }

    public function setRating(int $rating) : void {
        $this->rating = $rating;
    }

    final public function setCourseMessages(array $courseMessages) : void {
        if ($this->courseMessages !== []) {
            throw new AttributeAlreadySetDomainException('courseMessages attribute already been set and cannot be changed.');
        }
        $this->courseMessages = $courseMessages;
    }






    // toArray method
    abstract public function toArray() : array;


    public function course() : CourseEntity {
        $courseItem         = $this->getCourseItem();
        return $courseItem->getCourse();
    }

}
