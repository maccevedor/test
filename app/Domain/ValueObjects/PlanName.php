<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class PlanName
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Plan name cannot be empty.');
        }

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function equals(PlanName $other): bool
    {
        return $this->name === $other->getName();
    }

    public function __toString(): string
    {
        return $this->name;
    }
}