<?php

namespace App\Domain\ValueObjects;

use DateTimeImmutable;

use DateTimeInterface;
/* DateTimeInterface was created so that parameter, return, or property type declarations 
may accept either DateTimeImmutable or DateTime as a value */

use DateInterval;
//use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\ValueObjects\IValueObject;



class DateTimeVO implements IValueObject
{
    private DateTimeImmutable $datetime;

    public function __construct(DateTimeInterface $datetime) {
        $this->datetime = $datetime instanceof DateTimeImmutable ? $datetime : new DateTimeImmutable($datetime->format('Y-m-d H:i:s'));
    }

    public static function now() : self {
        return new self(new DateTimeImmutable());
    }

    public function getValue() : DateTimeImmutable {
        return $this->datetime;
    }

    public function isEqual(IValueObject $other) : bool {
        if (!$other instanceof self) {
            return false;
        }
        return $this->datetime == $other->datetime;
    }

    public function isAfter(IValueObject $other) : bool {
        return $this->datetime > $other->datetime;
    }

    public function isBefore(IValueObject $other) : bool {
        return $this->datetime < $other->datetime;
    }

    public function diff(IValueObject $other){
        $interval = $this->datetime->diff($other->getValue());
        return $interval;        
        //return $interval->format("%a days : %h hours : %i minutes : %s seconds");
    }

    public function add(DateInterval $interval) : IValueObject {
        $newDatetime = $this->datetime->add($interval);
        return new self($newDatetime);
    }

    public function subtract(DateInterval $interval) : IValueObject {
        $newDatetime = $this->datetime->sub($interval);
        return new self($newDatetime);
    }

    public function format() : string {
        return $this->datetime->format('Y-m-d');
    }
    
    /*
    public function format(string $format) : string {
        return $this->datetime->format($format);
    }
    */

    public static function createDate(DateTimeInterface $dateTime) : self {
        $newDateTime = new DateTimeImmutable($dateTime->format('Y-m-d') . ' 00:00:00');
        return new self($newDateTime);
    }



    // You can add more methods here as needed for other operations.
}






