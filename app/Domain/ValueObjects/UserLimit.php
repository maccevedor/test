<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class UserLimit
{
    private int $limit;

    public function __construct(int $limit)
    {
        if ($limit < 0) {
            throw new InvalidArgumentException('User limit cannot be negative.');
        }

        $this->limit = $limit;
    }

    public function toInt(): int
    {
        return $this->limit;
    }

    public function equals(UserLimit $other): bool
    {
        return $this->limit === $other->limit;
    }
}