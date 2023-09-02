<?php

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\InvalidArgumentDomainException;


class EmailAddress
{
    private string $address;

    public function __construct(string $address)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentDomainException('Invalid email address.');
        }

        $this->address = $address;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}

