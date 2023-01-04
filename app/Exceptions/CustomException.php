<?php


namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    private $_data = [];

    public function __construct($message, $data=[])
    {
        $this->_data = $data;
        parent::__construct($message);
    }

    public function getData($key=null)
    {
        return ($key===null)?$this->_data:($this->_data[$key]??'');
    }
}
