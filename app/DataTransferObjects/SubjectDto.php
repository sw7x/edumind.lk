<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\UserDto;
use App\DataTransferObjects\AbstractDto;



class SubjectDto extends AbstractDto{

	//public read only
    private string  $name;
	
    private ?int    $id;
	//private ?string $uuid;
	private ?string $description;
	private ?string $image;
	private ?string $slug;
	private ?string $status;

    private ?UserDto $authorDto;


    public function __construct(        
        string   $name,
        
        ?int     $id          = null,                
        //?string  $uuid      = null,
        ?string  $description = null,
        ?string  $image       = null,
        ?string  $slug        = null,
        ?string  $status      = null,

        ?UserDto $authorDto   = null
    ) {
        $this->name           = $name;
        
        $this->id             = $id;
        //$this->uuid         = $uuid,
        $this->description    = $description;
        $this->image          = $image;
        $this->slug           = $slug;
        $this->status         = $status;

        $this->authorDto      = $authorDto;
    }



    // GETTERS
	public function getId() : ?int {
        return $this->id;
    }

	/*
    public function getUuid() : ?string {
        return $this->uuid;
    }
    */

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

    public function getAuthorDto() : ?UserDto {
        return $this->authorDto;
    }

    
    public function toArray():array{
        return [
            'id' 			=> $this->id,
            //'uuid'        => $this->uuid,
            'name' 			=> $this->name,
            'description' 	=> $this->description,
            'image' 		=> $this->image,
            'slug' 			=> $this->slug,
            'status' 		=> $this->status,
            
            'creatorArr'     => $this->authorDto ? $this->authorDto->toArray() : null,
            'creatorId'      => $this->authorDto ? $this->authorDto->getId() : null,
        ];
    }

}






  

    

    