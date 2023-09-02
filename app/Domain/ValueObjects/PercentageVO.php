<?php

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\ValueObjects\IValueObject;



class PercentageVO implements IValueObject
{
    private float $value;

    public function __construct(float $value){
        if ($value < 0 || $value > 100) {
            //throw new InvalidArgumentDomainException('Percentage value must be between 0 and 100.');
        }

        $this->value = $value;
    }

    public static function fromFraction(float $fraction) : self {
        return new self($fraction * 100);
    }

    public function getValue() : float {
        return $this->value;
    }

    public function asFraction() : float {
        return $this->value / 100;
    }

    public function add(self $other) : self {
        return new self($this->value + $other->value);
    }

    public function subtract(self $other) : self {
        return new self($this->value - $other->value);
    }

    public function multiply(float $factor) : self{
        return new self($this->value * $factor);
    }

    public function divide(float $divisor) : self{
        return new self($this->value / $divisor);
    }

    public function isEqual(IValueObject $other) : bool{
        if (!$other instanceof self) {
            return false;
        }
        return $this->value === $other->value;
    }
    
    public function format() : string {      
        return $this->value . ' ' . '%';
    }







    // You can add more methods here as needed for other operations.
}
