<?php
namespace App\Domain\ValueObjects;

interface IValueObject{
	
    //public function isNull(): bool;
    //public static function fromNative($native);
    //public function toNative();



    public function format(): string;
    public function getValue();

    //public function add() : self;
    //public function subtract() : self;  

    public function isEqual(self $other) : bool;
}


