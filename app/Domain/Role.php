<?php


namespace App\Domain;

use App\Domain\Entity;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;

class Role extends Entity{
	
    private ?int     $id   = null;
	private ?string  $uuid = null;
	private string   $name;	
	private ?string  $slug = null;

	
	public function __construct(string $name){
		$this->name = $name;
	}
	
    

    // Getters 
	public function getId() : ?int {
        return $this->id;
    }
    
    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getSlug() : ?string {
        return $this->slug;
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
        
    public function setSlug(string $slug) : void {
        $this->slug = $slug;
    }





    // toArray method
    public function toArray() : array {
        return [
            'id' 		=> $this->id,
            'uuid' 		=> $this->uuid,
            'name' 		=> $this->name,
            'slug' 		=> $this->slug
        ];
    }

}