<?php

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\InvalidArgumentDomainException;

class Count
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentDomainException('Count value cannot be negative.');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function increment(): self
    {
        return new self($this->value + 1);
    }

    public function decrement(): self
    {
        if ($this->value === 0) {
            throw new \RuntimeException('Count cannot be decremented below zero.');
        }

        return new self($this->value - 1);
    }

    public function add(int $amount): self
    {
        return new self($this->value + $amount);
    }

    public function subtract(int $amount): self
    {
        if ($this->value < $amount) {
            throw new \RuntimeException('Count cannot be subtracted below zero.');
        }

        return new self($this->value - $amount);
    }

    public function isEqual(Count $other): bool
    {
        return $this->value === $other->value;
    }

    // You can add more methods here as needed for other operations.
}
