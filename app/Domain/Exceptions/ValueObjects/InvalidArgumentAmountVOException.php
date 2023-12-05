<?php


namespace App\Domain\Exceptions\ValueObjects;
use App\Domain\Exceptions\DomainException;


class InvalidArgumentAmountVOException extends DomainException {    
    public function __construct($message, $data=[]){
        parent::__construct($message);
        $this->_data = $data;
    }
}
