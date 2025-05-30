<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class PlanPrice
{
    private float $price;

    public function __construct(float $price)
    {
        if ($price < 0) {
            throw new InvalidArgumentException('Plan price cannot be negative.');
        }

        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function equals(PlanPrice $other): bool
    {
        return $this->price === $other->price;
    }
}