<?php


namespace App\Domain\Users;


use App\Domain\AbstractUser;




class Student extends AbstractUser {
	
	private $dobYear;
	private $profileText;
    
    public function __construct(        
        $fullName,
        $email,
        $phone,
        $username,
        $status,
        $dobYear
    ) {        
        parent::__construct(
            $fullName,
            $email,
            $phone,
            $username,
            $status
        );
        $this->dobYear = $dobYear;
    }

    public function getDobYear()
    {
        return $this->dobYear;
    }

    public function setDobYear($dobYear)
    {
        $this->dobYear = $dobYear;
    }


    public function getProfileText()
    {
        return $this->profileText;
    }

    public function setProfileText($profileText)
    {
        $this->profileText = $profileText;
    }

    public function toArray(){
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'username' => $this->username,
            'profilePic' => $this->profilePic,            
            'gender' => $this->gender,
            'dobYear' => $this->dobYear,
            'profileText' => $this->profileText,
            'status' => $this->status,
        ];
    }

}