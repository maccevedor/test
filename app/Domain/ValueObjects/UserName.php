<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class UserName
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('User name cannot be empty.');
        }

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function equals(UserName $other): bool
    {
        return $this->name === $other->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}