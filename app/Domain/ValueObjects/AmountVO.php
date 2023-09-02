<?php

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\ValueObjects\IValueObject;
use Money\Currency;
use Money\Money;

/*
In short: You shouldn't represent monetary values by a float. Wherever you need to represent money, use 
this Money value object. Since version 3.0 this library uses strings internally in order to support 
unlimited integers.
*/


class AmountVO implements IValueObject
{
    private Money $money;

    // $amount is in cents - Initialize Money instance with $1000 cents (equivalent to $10)
    public function __construct(float $amount, string $currencyCode = 'LKR'){
        $newAmount = (int)($amount * 100);
        if ($amount < 0) {
            throw new InvalidArgumentDomainException('Amount must be a non-negative integer.');
        }
        $currency    = new Currency($currencyCode);
        $this->money = new Money($newAmount, $currency);
    }
    
    // Convert cents to dollars (or other currency unit)
    public function getValue(): float {
        return $this->money->getAmount() / 100;
    }

    public function getCurrencyCode(): string {
        return $this->money->getCurrency()->getCode();
    }

    public function add(self $other): self {
        //$amount  = number_format($this->money->add($other->money)->getValue() / 100, 2);
        $amount  = (float) ($this->money->add($other->money)->getAmount() / 100);
        return new self($amount, $this->getCurrencyCode());
    }

    public function subtract(self $other): self {        
        $result  = $this->money->subtract($other->money);
        if ($result->isNegative()) {
            throw new InvalidArgumentDomainException('Subtraction result cannot be negative.');
        }  
        $amount  = (float) ($result->getAmount() / 100);
        //$amount  = number_format($result->getValue() / 100, 2);
        return new self($amount, $this->getCurrencyCode());
    }

    public function multiply(float $factor): self {
        $newAmount = (int) round($this->money->getAmount() * $factor);
        $amount  = (float)($newAmount / 100);
        return new self($amount, $this->getCurrencyCode());
    }
    
    public function isEqual(IValueObject $other): bool {
        if (!$other instanceof self) {
            return false;
        }
        return $this->money->equals($other->money);
    }

    public function isLower(self $other): bool {
        return $this->money->lessThan($other->money);
    }

    public function isHigher(AmountVO $other): bool {
        return $this->money->greaterThan($other->money);
    }

    private function getCurrencySymbol(string $currencyCode): string {
        $symbolMap = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'AUD' => 'A$',
            'CAD' => 'C$',            
            'CHF' => 'Fr.',
            'CNY' => 'CN¥',
            'INR' => '₹',
            'SGD' => 'S$',
            'AED' => 'د.إ',
            'ZAR' => 'R',
            'TRY' => '₺',
            'NZD' => 'NZ$',
            'LKR' => 'රු',
            // ... and so on
        ];
        return $symbolMap[$currencyCode] ?? $currencyCode;
    }

    // You can customize the formatting of the amount based on the currency and locale if needed.
    public function format(): string {      
        // Divide by 100 due to Money's base unit
        $formattedAmount  = (float) ($this->money->getAmount() / 100);
        $currencySymbol   = $this->getCurrencySymbol($this->getCurrencyCode());

        // Format the amount with currency symbol and separators
        $formattedAmountWithSymbol = $currencySymbol . ' ' . $formattedAmount;
        return $formattedAmountWithSymbol;
    }


    // You can add more methods here as needed for other operations.
}

















/*
class Amount{

    private int $value; // Assuming the amount is represented as an integer (e.g., cents)

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentDomainException('Amount must be a non-negative integer.');
        }

        $this->value = $value;
    }

    public function getValue() : int {
        return $this->value;
    }

    public function add(Amount $other) : Amount {
        return new Amount($this->value + $other->getValue());
    }

    public function subtract(Amount $other): Amount
    {
        $result = $this->value - $other->getValue();

        if ($result < 0) {
            throw new InvalidArgumentDomainException('Subtraction result cannot be negative.');
        }

        return new Amount($result);
    }

    public function multiply(float $multiplier) : Amount {
        $result = $this->value * $multiplier;
        return new Amount((int) round($result));
    }

    public function format(): string{
        // Format the amount to the desired format (e.g., add currency symbol, decimal separator, etc.)
        // For simplicity, let's assume the amount is represented in cents and we want to format it as dollars.

        $dollars = $this->value / 100;
        return '$' . number_format($dollars, 2);
    }    
}
*/