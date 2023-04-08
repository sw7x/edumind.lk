<?php


namespace App\Domain\User;


use App\Domain\User;


class Admin extends User {

}




public function isSubjectCreator(Subject $subject){        
        //dd(static::id);
        return ($this->id == $subject->creator->id);        
    }