<?php


namespace App\Domain;

use App\Domain\Users\User as UserEntity;
use App\Domain\Entity;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;

//created_at 
//updated_at
//deleted_at



class ContactUsMessage extends Entity
{
    private ?int     $id       = null;
    private ?string  $uuid     = null;
    private ?string  $fullName = null;
    private ?string  $email    = null;
    private ?string  $phone    = null;
    
    private string   $subject;
    private string   $message;
    
    
    /* associations */
    private ?UserEntity $creator = null;


    public function __construct(string $message, string $subject){
        $this->message = $message;
        $this->subject = $subject;
    }





    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }

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

    public function getCreator() : ?UserEntity {
        return $this->creator;
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

    final public function setFullName(string $fullName) : void {
        if ($this->fullName !== null) {
            throw new AttributeAlreadySetDomainException('fullName attribute already been set and cannot be changed.');
        }
        $this->fullName = $fullName;
    }

    final public function setEmail(string $email) : void {
        if ($this->email !== null) {
            throw new AttributeAlreadySetDomainException('email attribute already been set and cannot be changed.');
        }
        $this->email = $email;
    }

    final public function setPhone(string $phone) : void {        
        if ($this->phone !== null) {
            throw new AttributeAlreadySetDomainException('phone attribute already been set and cannot be changed.');
        }
        $this->phone = $phone;
    }
    
    final public function setCreator(UserEntity $creator) : void {
        if ($this->creator !== null) {
            throw new AttributeAlreadySetDomainException('creator attribute has already been set and cannot be changed.');
        }
        $this->creator = $creator;
    }




    // toArray method
    public function toArray() : array {
        return [
            'id' 		        => $this->id,
            'uuid' 		        => $this->uuid,
            'fullName' 	        => $this->fullName,
            'email' 	        => $this->email,
            'phone' 	        => $this->phone,
            'subject' 	        => $this->subject,
            'message' 	        => $this->message,
            
            'userArr'           => $this->creator ? $this->creator->toArray() : null,
            'userId'            => $this->creator ? $this->creator->getId()   : null,
        ];
    }
}
















