<?php


namespace App\Domain\Users;


use App\Domain\AbstractUser as AbstractUserEntity;

class User extends AbstractUserEntity{
        
    public function toArray() : array {

        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'fullName'      => $this->fullName,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'username'      => $this->username,
            'profilePic'    => $this->profilePic,          
            'gender'        => $this->gender,
            'status'        => $this->status,
            'isActivated'   => $this->isActivated,
            
            'roleArr'       => $this->role ? $this->role->toArray() : null,
            'roleId'        => $this->role ? $this->role->getId()   : null,
        ];
    }
}



/*
public function isSubjectCreator(Subject $subject){        
    //dd(static::id);
    return ($this->id == $subject->creator->id);        
}
*/