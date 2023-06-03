<?php


namespace App\Domain;



user_id ==> FK
created_at 
updated_at
//deleted_at



class ContactUsMessage
{
    private $id;
    private $uuid;
    private $fullName;
    private $email;
    private $phone;
    private $subject;
    private $message;

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getMessage()
    {
        return $this->message;
    }

    // toArray method
    public function toArray()
    {
        return [
            'id' 		=> $this->id,
            'uuid' 		=> $this->uuid,
            'fullName' 	=> $this->fullName,
            'email' 	=> $this->email,
            'phone' 	=> $this->phone,
            'subject' 	=> $this->subject,
            'message' 	=> $this->message,
        ];
    }
}



















