<?php


namespace App\Domain;
//use App\Domain\TeacherUser;
use App\Domain\Users\User as UserEntity;
use App\Domain\Subject;
use App\Domain\Entity;

use App\Domain\Exceptions\AttributeAlreadySetDomainException;

class Subject extends Entity{

	private ?int    $id          = null;
	private ?string $uuid        = null;
	private string  $name;
	private ?string $description = null;
	private ?string $image       = null;
	private ?string $slug        = null;
	private ?string $status      = null;
    
    /* associations */
    private ?UserEntity $author = null;  
    


    public function __construct(string $name){
        $this->name = $name;
    }



	

    // GETTERS
	public function getId() : ?int {
        return $this->id;
    }
    
    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function getImage() : ?string {
        return $this->image;
    }

    public function getSlug() : ?string {
        return $this->slug;
    }

    public function getStatus() : ?string {
        return $this->status;
    }

    public function getAuthor() : ?UserEntity {
        return $this->author;
    }

    



    // SETTERS
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

    public function setDescription(string $description) : void {
        $this->description = $description;
    }

    public function setImage(string $image) : void {
        $this->image = $image;
    }

    public function setSlug(string $slug) : void {
        $this->slug = $slug;
    }

    public function setStatus(string $status) : void {
        $this->status = $status;
    }
    
    public function setAuthor(UserEntity $author) : void {
        $this->author = $author;
    }
    



    public function toArray() : array {
        
        return [
            'id' 			=> $this->id,
            'uuid' 			=> $this->uuid,
            'name' 			=> $this->name,
            'description' 	=> $this->description,
            'image' 		=> $this->image,
            'slug' 			=> $this->slug,
            'status' 		=> $this->status,
            
            'creatorArr'    => $this->author ? $this->author->toArray() : null,
            'creatorId'     => $this->author ? $this->author->getId()   : null,
        ];
    }


}

