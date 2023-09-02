<?php


namespace App\Domain\Exceptions;

use App\Domain\Exceptions\DomainException;


class MissingArgumentDomainException extends DomainException{    
    public function __construct($message, $data=[]){
        parent::__construct($message);
        $this->_data = $data;
    }
}
