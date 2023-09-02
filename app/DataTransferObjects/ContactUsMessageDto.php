<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\UserDTO;
use App\DataTransferObjects\AbstractDto;


class ContactUsMessageDto extends AbstractDto{
    
    //public read only
    private     string   $message;
    private     string   $subject;
    
    private     ?int     $id;
    //private     ?string  $uuid;
    private     ?string  $fullName;
    private     ?string  $email;
    private     ?string  $phone;

    private     ?UserDTO $creatorDTO;

    
    public function __construct(
        string   $message,
        string   $subject, 
        
        ?int     $id         = null, 
        //?string  $uuid       = null, 
        ?string  $fullName   = null ,
        ?string  $email      = null , 
        ?string  $phone      = null , 

        ?UserDTO $creatorDTO = null
    ) {
        $this->subject       = $subject;
        $this->message       = $message;
        
        $this->id            = $id;
        //$this->uuid          = $uuid;
        $this->fullName      = $fullName;
        $this->email         = $email;
        $this->phone         = $phone;

        $this->creatorDTO    = $creatorDTO;
    }
        


    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    /*public function getUuid() : ?string {
        return $this->uuid;
    }*/

    public function getFullName() : ?string {
        return $this->fullName;
    }

    public function getEmail() : ?string {
        return $this->email;
    }

    public function getPhone() : ?string {
        return $this->phone;
    }

    public function getSubject() : string {
        return $this->subject;
    }

    public function getMessage() : string {
        return $this->message;
    }

    public function getCreator() : ?UserDTO {
        return $this->creatorDTO;
    }


    // toArray method
    public function toArray() : array {
        return [
            'id'            => $this->id,
            //'uuid'          => $this->uuid,
            'fullName'      => $this->fullName,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'subject'       => $this->subject,
            'message'       => $this->message,            
            
            "userArr"       => $this->creatorDTO ? $this->creatorDTO->toArray() : null,
            "userId"        => $this->creatorDTO ? $this->creatorDTO->getId() : null,
        ];
    }
    
}