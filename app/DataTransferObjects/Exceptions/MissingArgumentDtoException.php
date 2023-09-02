<?php
namespace App\DataTransferObjects\Exceptions;

use App\DataTransferObjects\Exceptions\DtoException;


class MissingArgumentDtoException extends DtoException{    
    public function __construct($message, $data=[]){
        parent::__construct($message);
        $this->_data = $data;
    }
}
