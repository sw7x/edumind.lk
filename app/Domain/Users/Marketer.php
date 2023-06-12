<?php


namespace App\Domain\Users;



use App\Domain\AbstractUser;



class Marketer extends AbstractUser {
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
            'status' => $this->status,
        ];
    }
}