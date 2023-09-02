<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\UserDTO;
use App\DataTransferObjects\AbstractDto;



class SubjectDto extends AbstractDto{

	//public read only
    private string  $name;
	
    private ?int    $id;
	//private ?string $uuid;
	private ?string $description;
	private ?string $image;
	private ?string $slug;
	private ?bool   $status;

    private ?UserDTO $authorDTO;


    public function __construct(        
        string   $name,
        
        ?int     $id          = null,                
        //?string  $uuid      = null,
        ?string  $description = null,
        ?string  $image       = null,
        ?string  $slug        = null,
        ?bool    $status      = null,

        ?UserDTO $authorDTO   = null
    ) {
        $this->name           = $name;
        
        $this->id             = $id;
        //$this->uuid         = $uuid,
        $this->description    = $description;
        $this->image          = $image;
        $this->slug           = $slug;
        $this->status         = $status;

        $this->authorDTO      = $authorDTO;
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
    
    public function getStatus() : ?bool {
        return $this->status;
    }

    public function getAuthor() : ?UserDTO {
        return $this->authorDTO;
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
            
            'creatorArr'     => $this->authorDTO ? $this->authorDTO->toArray() : null,
            'creatorId'      => $this->authorDTO ? $this->authorDTO->getId() : null,
        ];
    }

}






  

    

    