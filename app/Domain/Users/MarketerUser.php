<?php


namespace App\Domain\Users;



use App\Domain\AbstractUser as AbstractUserEntity;
use App\Domain\Users\User as UserEntity;


class MarketerUser extends UserEntity {
    /* 
    public function toArray(){
        return [
            'id'        => $this->id,
            'uuid'      => $this->uuid,
            'fullName'  => $this->fullName,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'username'  => $this->username,
            'profilePic'=> $this->profilePic,
            'gender'    => $this->gender,
            'status'    => $this->status,
        ];
    } 
    */
}