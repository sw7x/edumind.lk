<?php


namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;


class RoleDto extends AbstractDto{
	
	//public read only
    private string    $name;    
    private ?int      $id;
	//private ?string $uuid;
	private ?string   $slug;

	
	public function __construct(
        string      $name, 
        
        ?int        $id     = null,
        //?string  $uuid    = null, 
        ?string     $slug   = null
    ) {
        $this->name         = $name;
		
        $this->id           = $id;
        //$this->uuid       = $uuid,
        $this->slug         = $slug;
	}
	
	public function getId() : ?int {
        return $this->id;
    }

	public function getName() : string {
        return $this->name;
    }

    public function getSlug() : ?string {
        return $this->slug;
    }
  

    // toArray method
    public function toArray() : array {
        
        return [
            'id' 		=> $this->id,
            //'uuid' 		=> $this->uuid,
            'name' 		=> $this->name,
            'slug' 		=> $this->slug
        ];
    }

}

//created_at
//updated_at    


