<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class CompanyName
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Company name cannot be empty.');
        }

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function equals(CompanyName $other): bool
    {
        return $this->name === $other->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}