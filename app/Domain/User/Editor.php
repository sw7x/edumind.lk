<?php


namespace App\Domain\User;

use App\Domain\User;



class Editor extends User {

}




public function isSubjectCreator(Subject $subject){        
        //dd(static::id);
        return ($this->id == $subject->creator->id);        
    }